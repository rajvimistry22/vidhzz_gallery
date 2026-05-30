<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'sku',
        'subcategory',
        'short_description',
        'description',
        'price',
        'sale_price',
        'stock',
        'unit',
        'weight',
        'sizes',
        'colors',
        'material',
        'is_featured',
        'is_trending',
        'is_new_arrival',
        'is_active',
        'sort_order',
        'views',
        'rating',
        'reviews_count',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'sizes' => 'array',
        'colors' => 'array',
        'is_featured' => 'boolean',
        'is_trending' => 'boolean',
        'is_new_arrival' => 'boolean',
        'is_active' => 'boolean',
        'rating' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->where('is_approved', true);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function getEffectivePriceAttribute(): float
    {
        return $this->sale_price ? (float) $this->sale_price : (float) $this->price;
    }

    public function getDiscountPercentAttribute(): int
    {
        if (! $this->sale_price || (float) $this->price === 0.0) {
            return 0;
        }

        return (int) round((((float) $this->price - (float) $this->sale_price) / (float) $this->price) * 100);
    }

    public function getIsOnSaleAttribute(): bool
    {
        return filled($this->sale_price) && (float) $this->sale_price < (float) $this->price;
    }

    public function getIsInStockAttribute(): bool
    {
        return $this->stock > 0;
    }

    public function getThumbnailAttribute(): string
    {
        $image = $this->images->where('is_primary', true)->first() ?? $this->images->first();

        if ($image && \Illuminate\Support\Facades\Storage::disk('public')->exists($image->image_path)) {
            return asset('storage/' . $image->image_path);
        }

        return asset('images/placeholders/product.svg');
    }

    public function getGalleryUrlsAttribute(): array
    {
        $urls = $this->images->map(fn ($image) => $image->url)->all();

        if (empty($urls)) {
            $urls[] = asset('images/placeholders/product.svg');
        }

        return array_values(array_unique($urls));
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rs. ' . number_format((float) $this->price, 0);
    }

    public function getFormattedSalePriceAttribute(): string
    {
        return $this->sale_price ? 'Rs. ' . number_format((float) $this->sale_price, 0) : '';
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeTrending($query)
    {
        return $query->where('is_trending', true);
    }

    public function scopeNewArrival($query)
    {
        return $query->where('is_new_arrival', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function scopeSearch($query, string $term)
    {
        return $query->where(function ($innerQuery) use ($term) {
            $innerQuery
                ->where('name', 'like', "%{$term}%")
                ->orWhere('short_description', 'like', "%{$term}%")
                ->orWhere('description', 'like', "%{$term}%")
                ->orWhere('sku', 'like', "%{$term}%");

            if (Schema::hasColumn('products', 'subcategory')) {
                $innerQuery->orWhere('subcategory', 'like', "%{$term}%");
            }
        });
    }

    public function scopeSorted($query, ?string $sort)
    {
        return match ($sort) {
            'price_asc' => $query->orderByRaw('COALESCE(sale_price, price) asc'),
            'price_desc' => $query->orderByRaw('COALESCE(sale_price, price) desc'),
            'popular' => $query->orderByDesc('views')->orderByDesc('is_trending'),
            default => $query->orderByDesc('is_featured')->orderBy('sort_order')->latest(),
        };
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
