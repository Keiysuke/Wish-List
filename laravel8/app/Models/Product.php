<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\ProductWebsite;
use App\Models\Purchase;
use App\Models\Selling;
use App\Models\ProductPhoto;
use App\Models\Listing;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['label', 'description', 'img_ext', 'limited_edition', 'real_cost'];
    
    public function users(){
        return $this->belongsToMany(User::class, 'product_users')->withPivot('archive')->withTimestamps();
    }
    
    public function listings(){
        return $this->belongsToMany(Listing::class, 'listing_products')->withTimestamps();
    }
    
    public function productWebsites(){
        return $this->hasMany(ProductWebsite::class);
    }
    
    public function creator(){
        return $this->belongsTo(User::class);
    }
    
    public function purchases(){
        if(\Auth::user()) return $this->hasMany(Purchase::class)->where('user_id', '=', \Auth::user()->id);
        else return $this->hasMany(Purchase::class);
    }
    
    public function sellings(){
        if(\Auth::user()) return $this->hasMany(Selling::class)->where('user_id', '=', \Auth::user()->id);
        else return $this->hasMany(Selling::class);
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

    public function getwebsitesExpirationSoon(){
        return $this->productWebsites()->where('expiration_date', '>=', date("Y-m-d"))->orderBy('expiration_date')->get();
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

    public function following(){
        $this->following = count(User::whereHas('products', function($query){
            $query->where('user_id', '=', \Auth::user()->id)
                ->where('product_id', '=', $this->id);
        })->get()) >= 1;
    }

    public function createdBy(){
        $this->created = $this->created_by == \Auth::user()->id;
    }

    public function bestWebsiteOffer(){
        $res = ['price' => $this->real_cost, 'url' => null];
        foreach($this->getAvailableWebsites() as $offer){
            if($offer->price <= $res['price']){
                $res = ['price' => $offer->price, 'url' => $offer->url];
            }
        }
        return array_merge($res, ['color' => ($res['price'] < $this->real_cost)? 'green' : (($res['price'] > $this->real_cost)? 'red' : 'black')]);
    }
}
