<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = ['product_id','size','color','color_hex','stock','price_adjustment','sku'];
    protected $casts    = ['price_adjustment' => 'decimal:2'];

    public function product() { return $this->belongsTo(Product::class); }

    public function getIsInStockAttribute(): bool { return $this->stock > 0; }

    public function getLabelAttribute(): string
    {
        $parts = [];
        if ($this->size)  $parts[] = "Size: {$this->size}";
        if ($this->color) $parts[] = "Color: {$this->color}";
        return implode(', ', $parts);
    }
}
