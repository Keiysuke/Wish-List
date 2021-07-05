<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductWebsite;
use App\Models\Purchase;
use App\Models\Selling;

class Website extends Model
{
    use HasFactory;
    protected $fillable = ['label', 'url', 'can_sell'];

    public function product_websites(){
        return $this->hasMany(ProductWebsite::class);
    }

    public function purchases(){
        return $this->hasMany(Purchase::class);
    }

    public function sellings(){
        return $this->hasMany(Selling::class);
    }
}
