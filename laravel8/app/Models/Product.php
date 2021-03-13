<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductWebsite;
use App\Models\Purchase;
use App\Models\Selling;
use App\Models\ProductPhoto;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['label', 'description', 'img_ext', 'limited_edition', 'real_cost'];
    
    public function productWebsites(){
        return $this->hasMany(ProductWebsite::class);
    }
    
    public function purchases(){
        return $this->hasMany(Purchase::class);
    }
    
    public function sellings(){
        return $this->hasMany(Selling::class);
    }
    
    public function photos(){
        return $this->hasMany(ProductPhoto::class);
    }

    //Utils
    public function getAvailableWebsites(){
        return $this->productWebsites()->where(function($query){
            $query->where('available_date', '<=', date("Y-m-d"))
                ->orWhereNull('available_date')
                ->orWhere('available_date', '>', date("Y-m-d"));
        })->where(function($query){
            $query->where('expiration_date', '>', date("Y-m-d"))
                ->orWhereNull('expiration_date');
        })->orderBy('available_date')->get();
    }

    public function getwebsitesAvailableSoon(){
        return $this->productWebsites()->where('available_date', '>=', date("Y-m-d"))->orderBy('available_date')->get();
    }

    public function isAvailable(){
        return $this->whereHas('productWebsites', function($query){
            $query->where([['available_date', '<=', date("Y-m-d H:i:s")], ['expiration_date', '>', date("Y-m-d")]])
                ->orWhere([['available_date', '<=', date("Y-m-d H:i:s")], ['expiration_date', '=', null]])
                ->orWhere([['available_date', '=', null], ['expiration_date', '>', date("Y-m-d")]])
                ->orWhere([['available_date', '=', null], ['expiration_date', '=', null]]);
        });
    }

    public function availableSoon(){
        return $this->whereHas('productWebsites', function($query){
            $query->where([['available_date', '>', date("Y-m-d H:i:s")], ['available_date', '<>', null]]);
        });
    }

    public function hasExpired(){
        return $this->whereHas('productWebsites', function($query){
            $query->where([['expiration_date', '<>', null], ['expiration_date', '<=', date("Y-m-d H:i:s")], ['available_date', '=', null]]);
        });
    }
}
