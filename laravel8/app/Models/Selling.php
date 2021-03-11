<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Website;
use App\Models\ProductState;
use App\Models\SellState;
use App\Models\Purchase;

class Selling extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'product_state_id', 'purchase_id', 'website_id', 'sell_state_id', 'price', 'confirmed_price', 'shipping_fees', 'shipping_fees_payed', 'nb_views', 'date_begin', 'date_sold', 'date_send', 'box'];

    public function product(){
        return $this->belongsTo(Product::class);
    }
    
    public function website(){
        return $this->belongsTo(Website::class);
    }
    
    public function productState(){
        return $this->belongsTo(ProductState::class);
    }
    
    public function sellState(){
        return $this->belongsTo(SellState::class);
    }

    public function purchase(){
        return $this->hasOne(Purchase::class);
    }

    public function resold(){
        return $this->sellState()->first()->label === 'Terminée';
    }
}
