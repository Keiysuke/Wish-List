<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\GroupBuyPurchase;
use Illuminate\Support\Facades\DB;

class GroupBuy extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'label', 'date', 'global_cost', 'shipping_fees'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function group_buy_purchases(){
        return $this->hasMany(GroupBuyPurchase::class);
    }

    public function grouped_purchases(){ //Return a collection of purchases grouped by product_id and with the number for each of them
        $distinct_products = [];
        $r = collect([]);
        foreach($this->group_buy_purchases as $group_buy_purchase){
            $product_id = $group_buy_purchase->purchase->product_id;
            $cost = $group_buy_purchase->purchase->cost;
            $key = $product_id.'_'.$cost;
            if(!array_key_exists($key, $distinct_products)){
                $distinct_products[$key] = 1;
                $r = $r->push($group_buy_purchase->purchase); //We only keep the first purchase of each product
            }else{
                $distinct_products[$key]++; //Another same product for that group buy
            }
        }

        //We modify each purchase to keep the number of same couple product/purchase for that group buy
        foreach($distinct_products as $key => $v){
            $r->transform(function($item, $k) use($key, $v){
                if($item->product_id.'_'.$item->cost === $key) $item->nb = $v;
                return $item;
            });
        }
        return $r;
    }
}
