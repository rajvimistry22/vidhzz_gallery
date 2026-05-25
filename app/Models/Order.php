<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'coupon_id',
        'order_number',
        'status',
        'payment_status',
        'payment_method',
        'subtotal',
        'discount',
        'shipping_charge',
        'tax',
        'total',
        'coupon_code',
        'shipping_name',
        'shipping_phone',
        'shipping_address',
        'shipping_city',
        'shipping_state',
        'shipping_pincode',
        'shipping_country',
        'billing_name',
        'billing_phone',
        'billing_address',
        'billing_city',
        'billing_state',
        'billing_pincode',
        'billing_country',
        'notes',
        'shipped_at',
        'delivered_at',
        'tracking_number',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'shipping_charge' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'status-pending',
            'confirmed' => 'status-confirmed',
            'processing' => 'status-processing',
            'shipped' => 'status-shipped',
            'delivered' => 'status-delivered',
            'cancelled', 'refunded' => 'status-cancelled',
            default => 'status-pending',
        };
    }

    public function getFormattedTotalAttribute(): string
    {
        return 'Rs. ' . number_format((float) $this->total, 0);
    }

    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeRecent($query)
    {
        return $query->orderByDesc('created_at');
    }

    public static function generateOrderNumber(): string
    {
        return 'VID-' . strtoupper(substr(uniqid(), -6)) . '-' . date('ymd');
    }

    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending', 'confirmed'], true);
    }
}
