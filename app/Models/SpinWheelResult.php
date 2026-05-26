<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SpinWheelResult extends Model
{
    protected $fillable = [
        'session_id',
        'user_id',
        'reward_label',
        'segment_index',
        'coupon_code',
        'ip_address',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
