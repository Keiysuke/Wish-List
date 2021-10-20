<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Product;
use App\Models\Website;
use App\Models\Selling;
use App\Models\ProductState;
use App\Models\GroupBuyPurchase;

class Purchase extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'product_id', 'product_state_id', 'website_id', 'cost', 'discount', 'date', 'customs'];

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

    public function selling(){
        return $this->hasOne(Selling::class);
    }

    public function group_buy_purchases(){
        return $this->hasMany(GroupBuyPurchase::class);
    }

    public function getBenefice(){
        $s = $this->selling()->first();
        $price_sold = ($s->confirmed_price + $s->shipping_fees);
        //Old
        // $price_sold -= ($price_sold*3.05)/100;
        // $price_sold -= (((($s->confirmed_price* 8) / 100)* 20) / 100) + (($s->confirmed_price* 8) / 100);
        //New
        $price_sold -= ($price_sold*11.08)/100;
        return $price_sold - ($this->cost - $this->discount + $s->shipping_fees_payed + $this->customs);
    }
}
