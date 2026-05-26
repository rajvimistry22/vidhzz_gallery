<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SpinWheelResult;
use Illuminate\Http\Request;

class SpinWheelController extends Controller
{
    public function index(Request $request)
    {
        $results = SpinWheelResult::with('user')
            ->latest()
            ->paginate(20);

        $stats = [
            'total_spins'     => SpinWheelResult::count(),
            'coupons_given'   => SpinWheelResult::whereNotNull('coupon_code')->count(),
            'try_again_count' => SpinWheelResult::where('reward_label', 'Try Again')->count(),
            'today_spins'     => SpinWheelResult::whereDate('created_at', today())->count(),
        ];

        // Prize breakdown
        $prizeBreakdown = SpinWheelResult::selectRaw('reward_label, COUNT(*) as count')
            ->groupBy('reward_label')
            ->orderByDesc('count')
            ->get();

        return view('admin.spin-wheel.index', compact('results', 'stats', 'prizeBreakdown'));
    }
}
