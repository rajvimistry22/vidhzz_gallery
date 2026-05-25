<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'title','subtitle','image','mobile_image','cta_text','cta_url',
        'badge_text','position','is_active','sort_order',
    ];
    protected $casts = ['is_active' => 'boolean'];

    public function getImageUrlAttribute(): string
    {
        return $this->image ? asset('storage/' . $this->image) : '';
    }

    public function scopeActive($query)   { return $query->where('is_active', true); }
    public function scopeHero($query)     { return $query->where('position', 'hero')->orderBy('sort_order'); }
    public function scopeCategory($query) { return $query->where('position', 'category'); }
}
