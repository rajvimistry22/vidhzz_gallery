<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'variant_id',
        'product_name',
        'product_sku',
        'variant_info',
        'product_image',
        'quantity',
        'price',
        'subtotal',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function getProductImageUrlAttribute(): string
    {
        if ($this->product_image && file_exists(public_path('storage/' . $this->product_image))) {
            return asset('storage/' . $this->product_image);
        }

        return asset('images/placeholders/product.svg');
    }
}
