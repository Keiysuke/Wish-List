<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Selling;
use App\Models\Listing;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function products(){
        return $this->belongsToMany(Product::class, 'product_users')->withPivot('archive')->withTimestamps();
    }
    
    public function listings(){
        return $this->belongsToMany(Listing::class, 'listing_products')->withTimestamps();
    }

    public function createdProducts(){
        return $this->hasMany(Product::class);
    }
    
    public function sellings(){
        return $this->hasMany(Selling::class);
    }
    
    public function purchases(){
        return $this->hasMany(Purchase::class);
    }
}
