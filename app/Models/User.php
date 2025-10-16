<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role'];

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function vendorProfile()
    {
        return $this->hasOne(Vendor::class, 'user_id');
    }

    // Role check helpers
    public function isAdmin(): bool { return $this->role === 'admin'; }
    public function isVendor(): bool { return $this->role === 'vendor'; }
    public function isCustomer(): bool { return $this->role === 'customer'; }
}
