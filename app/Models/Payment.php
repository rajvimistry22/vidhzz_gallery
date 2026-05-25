<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id','razorpay_order_id','razorpay_payment_id','razorpay_signature',
        'amount','currency','status','method','raw_response','paid_at',
    ];

    protected $casts = [
        'amount'       => 'decimal:2',
        'raw_response' => 'array',
        'paid_at'      => 'datetime',
    ];

    public function order() { return $this->belongsTo(Order::class); }

    public function getIsPaidAttribute(): bool { return $this->status === 'paid'; }
}
