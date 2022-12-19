<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\User;
use App\Models\ListingType;

class Listing extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'listing_type_id', 'label', 'description', 'secret'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function listing_type(){
        return $this->belongsTo(ListingType::class);
    }
    
    public function products(){
        return $this->belongsToMany(Product::class, 'listing_products')->withTimestamps();
    }
    
    public function users(){
        return $this->belongsToMany(User::class, 'listing_users')->withTimestamps();
    }

    public function getProducts($with_extra = true){
        $products = app('App\Http\Controllers\ProductController')->get_products($this->products()->paginate());
        
        if ($with_extra) {
            foreach($products as $product) $product->nb = ListingProduct::where('product_id', '=', $product->id)->first()->nb;

            $products->total_price = 0;
            foreach($products as $product) $products->total_price += $product->real_cost * $product->nb;
        }
        return $products;
    }
}
