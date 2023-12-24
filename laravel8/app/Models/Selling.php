<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Product;
use App\Models\Website;
use App\Models\ProductState;
use App\Models\SellState;
use App\Models\Purchase;
use App\Models\HistoSellingOffer;

class Selling extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'product_id', 'product_state_id', 'purchase_id', 'website_id', 'sell_state_id', 'price', 'confirmed_price', 'shipping_fees', 'shipping_fees_payed', 'nb_views', 'date_begin', 'date_sold', 'date_send', 'box'];

    public function user(){
        return $this->belongsTo(User::class);
    }

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
        return $this->belongsTo(Purchase::class);
    }

    public function histo_offers(){
        return $this->hasMany(HistoSellingOffer::class);
    }

    public function isSold(){
        return $this->sellState()->first()->id === SellState::CLOSED;
    }

    public function price(){
        return is_null($this->confirmed_price)? $this->price : $this->confirmed_price;
    }
}
