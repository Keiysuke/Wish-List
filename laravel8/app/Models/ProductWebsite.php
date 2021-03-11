<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Website;

class ProductWebsite extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'website_id', 'price', 'url', 'available_date', 'expiration_date'];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function website(){
        return $this->belongsTo(Website::class);
    }
}
