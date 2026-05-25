<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code','type','value','min_order_amount','max_discount',
        'usage_limit','used_count','per_user_limit','is_active','starts_at','expires_at',
    ];

    protected $casts = [
        'value'            => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'max_discount'     => 'decimal:2',
        'is_active'        => 'boolean',
        'starts_at'        => 'datetime',
        'expires_at'       => 'datetime',
    ];

    public function getIsValidAttribute(): bool
    {
        if (!$this->is_active) return false;
        if ($this->expires_at && $this->expires_at->isPast()) return false;
        if ($this->starts_at  && $this->starts_at->isFuture()) return false;
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) return false;
        return true;
    }

    public function calculateDiscount(float $subtotal): float
    {
        if ($subtotal < $this->min_order_amount) return 0;

        $discount = $this->type === 'percent'
            ? ($subtotal * $this->value / 100)
            : $this->value;

        if ($this->max_discount) {
            $discount = min($discount, $this->max_discount);
        }

        return round($discount, 2);
    }
}
