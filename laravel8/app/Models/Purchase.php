<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Product;
use App\Models\Website;
use App\Models\Selling;
use App\Models\ProductState;

class Purchase extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'product_id', 'product_state_id', 'website_id', 'cost', 'date'];

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

    public function getBenefice(){
        $s = $this->selling()->first();
        return ($s->confirmed_price + $s->shipping_fees) - ($this->cost + $s->shipping_fees_payed);
    }
}
