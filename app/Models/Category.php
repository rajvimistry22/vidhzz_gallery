<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'banner_image',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function images()
    {
        return $this->hasMany(CategoryImage::class)->orderBy('sort_order');
    }

    public function activeProducts()
    {
        return $this->hasMany(Product::class)->where('is_active', true);
    }

    public function getImageUrlAttribute(): string
    {
        $galleryImage = $this->images->where('is_primary', true)->first() ?? $this->images->first();

        if ($galleryImage) {
            return $galleryImage->url;
        }

        if ($this->image && file_exists(public_path('storage/' . $this->image))) {
            return asset('storage/' . $this->image);
        }

        return asset('images/placeholders/category.svg');
    }

    public function getBannerUrlAttribute(): string
    {
        if ($this->banner_image && file_exists(public_path('storage/' . $this->banner_image))) {
            return asset('storage/' . $this->banner_image);
        }

        return asset('images/placeholders/banner.svg');
    }

    public function getGalleryUrlsAttribute(): array
    {
        $urls = $this->images->map(fn ($image) => $image->url)->all();

        if (empty($urls) && $this->image_url) {
            $urls[] = $this->image_url;
        }

        return array_values(array_unique($urls));
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
