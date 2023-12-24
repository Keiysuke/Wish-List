<?php

namespace App\Models;

use App\Http\Controllers\UtilsController;
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
    protected $fillable = ['user_id', 'product_id', 'product_state_id', 'website_id', 'cost', 'discount', 'date', 'date_received', 'customs'];

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
    
    public function price(){
        return $this->cost - $this->discount;
    }

    public function date($format = 'd/m/Y'){
        return UtilsController::getDate($this->date, $format);
    }

    public function getBenefits(){
        $s = $this->selling()->first();
        $price_sold = ($s->confirmed_price + $s->shipping_fees);
        //No comission if I haven't paid fees (I can have sold it in hand)
        $price_sold -= ($s->shipping_fees > 0) ? UtilsController::getCommission($price_sold) : 0;
        return $price_sold - ($this->cost - $this->discount + $s->shipping_fees_payed + $this->customs);
    }
}
