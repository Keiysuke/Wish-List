<?php

namespace App\Models;

use App\Http\Controllers\UtilsController;
use App\Services\DateService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Product;
use App\Models\Website;
use App\Models\Selling;
use App\Models\ProductState;
use App\Models\GroupBuyPurchase;
use App\Models\Crowdfunding;

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

    public function crowdfunding(){
        return Crowdfunding::where('product_id', $this->product_id)
            ->where('website_id', $this->website_id)
            ->first();
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
    
    public function calculatePrice(){
        return $this->cost - $this->discount;
    }

    public function date($format = 'd/m/Y'){
        return DateService::getDate($this->date, $format);
    }

    public function getBenefits(){
        $s = $this->selling()->first();
        $priceSold = ($s->confirmed_price + $s->shipping_fees);
        //No comission if I haven't paid fees (I can have sold it in hand)
        $priceSold -= ($s->shipping_fees > 0) ? UtilsController::getCommission($priceSold) : 0;
        return $priceSold - ($this->cost - $this->discount + $s->shipping_fees_payed + $this->customs);
    }
}
