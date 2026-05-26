<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\SpinWheelResult;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SpinWheelController extends Controller
{
    /**
     * Prize segments — order must match the visual wheel segments (0–5, clockwise from top).
     * Weights must sum to 100.
     */
    private array $rewards = [
        0 => ['label' => '5% OFF',        'type' => 'percent', 'value' => 5,   'weight' => 35, 'prefix' => 'SPIN5'],
        1 => ['label' => '15% OFF',       'type' => 'percent', 'value' => 15,  'weight' => 10, 'prefix' => 'SPIN15'],
        2 => ['label' => 'Free Shipping', 'type' => 'fixed',   'value' => 150, 'weight' => 17, 'prefix' => 'SPINSHIP'],
        3 => ['label' => 'Try Again',     'type' => null,      'value' => 0,   'weight' => 15, 'prefix' => null],
        4 => ['label' => '10% OFF',       'type' => 'percent', 'value' => 10,  'weight' => 20, 'prefix' => 'SPIN10'],
        5 => ['label' => '20% OFF',       'type' => 'percent', 'value' => 20,  'weight' => 3,  'prefix' => 'SPIN20'],
    ];

    /**
     * Check if the current session has already spun.
     */
    public function check(Request $request): JsonResponse
    {
        $sessionId = $request->session()->getId();
        $query = SpinWheelResult::query();
        if (auth()->check()) {
            $query->where(function ($q) use ($sessionId) {
                $q->where('user_id', auth()->id())
                  ->orWhere('session_id', $sessionId);
            });
        } else {
            $query->where('session_id', $sessionId);
        }
        $alreadySpun = $query->whereDate('created_at', today())->exists();

        return response()->json(['already_spun' => $alreadySpun]);
    }

    /**
     * Execute the spin: pick a weighted reward, generate coupon, store result.
     */
    public function spin(Request $request): JsonResponse
    {
        $sessionId = $request->session()->getId();

        // One spin per user or session per day
        $query = SpinWheelResult::query();
        if (auth()->check()) {
            $query->where(function ($q) use ($sessionId) {
                $q->where('user_id', auth()->id())
                  ->orWhere('session_id', $sessionId);
            });
        } else {
            $query->where('session_id', $sessionId);
        }
        if ($query->whereDate('created_at', today())->exists()) {
            return response()->json(['error' => 'Already spun today.'], 422);
        }

        $segmentIndex = $this->pickWeightedSegment();
        $reward       = $this->rewards[$segmentIndex];
        $couponCode   = null;

        // Generate a coupon only for real prizes
        if ($reward['type'] !== null) {
            $couponCode = $this->generateCoupon($reward);
        }

        SpinWheelResult::create([
            'session_id'    => $sessionId,
            'user_id'       => auth()->id(),
            'reward_label'  => $reward['label'],
            'segment_index' => $segmentIndex,
            'coupon_code'   => $couponCode,
            'ip_address'    => $request->ip(),
        ]);

        return response()->json([
            'reward'        => $reward['label'],
            'segment_index' => $segmentIndex,
            'coupon_code'   => $couponCode,
        ]);
    }

    private function pickWeightedSegment(): int
    {
        $totalWeight = array_sum(array_column($this->rewards, 'weight'));
        $rand        = mt_rand(1, $totalWeight);
        $cumulative  = 0;

        foreach ($this->rewards as $index => $reward) {
            $cumulative += $reward['weight'];
            if ($rand <= $cumulative) {
                return $index;
            }
        }

        return 0;
    }

    private function generateCoupon(array $reward): string
    {
        $code = strtoupper($reward['prefix'] . '-' . Str::random(6));

        Coupon::create([
            'code'              => $code,
            'type'              => $reward['type'],
            'value'             => $reward['value'],
            'min_order_amount'  => 0,
            'max_discount'      => $reward['type'] === 'percent' ? ($reward['value'] >= 20 ? 500 : 300) : null,
            'usage_limit'       => 1,
            'used_count'        => 0,
            'per_user_limit'    => 1,
            'is_active'         => true,
            'is_spin_reward'    => true,
            'spin_reward_label' => $reward['label'],
            'expires_at'        => now()->addHours(48),
        ]);

        return $code;
    }
}
