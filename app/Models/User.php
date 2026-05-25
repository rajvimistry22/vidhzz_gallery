<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'phone', 'password', 'role', 'avatar', 'is_active',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'is_active'         => 'boolean',
    ];

    public function isAdmin(): bool   { return $this->role === 'admin'; }
    public function isCustomer(): bool { return $this->role === 'customer'; }

    public function orders()    { return $this->hasMany(Order::class); }
    public function addresses() { return $this->hasMany(Address::class); }
    public function wishlist()  { return $this->hasMany(Wishlist::class); }
    public function reviews()   { return $this->hasMany(Review::class); }
    public function cart()      { return $this->hasOne(Cart::class); }

    public function defaultAddress()
    {
        return $this->addresses()->where('is_default', true)->where('type', 'shipping')->first();
    }

    public function getAvatarUrlAttribute(): string
    {
        return $this->avatar
            ? asset('storage/' . $this->avatar)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=d4991e&color=fff';
    }
}
