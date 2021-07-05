<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Product;

class Listing extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'label', 'description', 'secret'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    
    public function products(){
        return $this->belongsToMany(Product::class, 'listing_products')->withTimestamps();
    }
    
    public function users(){
        return $this->belongsToMany(User::class, 'listing_users')->withTimestamps();
    }
}
