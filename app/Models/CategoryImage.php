<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryImage extends Model
{
    protected $fillable = [
        'category_id',
        'image_path',
        'alt_text',
        'is_primary',
        'sort_order',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getUrlAttribute(): string
    {
        if ($this->image_path && file_exists(public_path('storage/' . $this->image_path))) {
            return asset('storage/' . $this->image_path);
        }

        return asset('images/placeholders/category.svg');
    }
}
