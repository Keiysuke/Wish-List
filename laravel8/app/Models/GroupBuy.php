<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\GroupBuyPurchase;

class GroupBuy extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'label', 'date', 'global_cost', 'shipping_fees', 'discount'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function group_buy_purchases(){
        return $this->hasMany(GroupBuyPurchase::class);
    }

    public function travel_step_products()
    {
        return $this->hasMany(TravelStepProduct::class);
    }

    public function setDatas(){
        $purchasesId = [];
        foreach($this->group_buy_purchases as $p){
            $purchasesId[] = $p->purchase_id;
        }
        $this->datas = compact('purchasesId');
    }

    public function has_purchases(){
        return $this->count_purchases() >= 1;
    }

    public function count_purchases(){
        return count($this->group_buy_purchases()->get());
    }

    public function grouped_purchases(){ //Return a collection of purchases grouped by product_id and with the number for each of them
        $distinctProducts = [];
        $r = collect([]);
        foreach($this->group_buy_purchases as $groupBuyPurchase){
            $productId = $groupBuyPurchase->purchase->product_id;
            $cost = $groupBuyPurchase->purchase->cost;
            $key = $productId.'_'.$cost;
            if(!array_key_exists($key, $distinctProducts)){
                $distinctProducts[$key] = 1;
                $r = $r->push($groupBuyPurchase->purchase); //We only keep the first purchase of each product
            }else{
                $distinctProducts[$key]++; //Another same product for that group buy
            }
        }

        //We modify each purchase to keep the number of same couple product/purchase for that group buy
        foreach($distinctProducts as $key => $v){
            $r->transform(function($item, $k) use($key, $v){
                if($item->product_id.'_'.$item->cost === $key) $item->nb = $v;
                return $item;
            });
        }
        return $r;
    }
}
