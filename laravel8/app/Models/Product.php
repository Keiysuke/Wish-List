<?php

namespace App\Models;

use App\Http\Controllers\ProductPhotoController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\ProductWebsite;
use App\Models\Purchase;
use App\Models\Selling;
use App\Models\ProductPhoto;
use App\Models\Listing;
use App\Models\Tag;

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

    public function video_game(){
        return $this->hasOne(ProductAsVideoGame::class);
    }
    
    public function tags(){
        return $this->belongsToMany(Tag::class, 'product_tags')->withTimestamps();
    }

    public function tag_ids(){
        $res = [];
        foreach($this->tags as $tag){
            $res[] = $tag->id;
        }
        return $res;
    }

    public function isBook(){
        foreach($this->tags as $tag){
            if ($tag->isBook()) return true;
        }
        return false;
    }
    
    public function creator(){
        return $this->hasOne(User::class, 'id', 'created_by')->first();
    }
    
    public function purchases(){
        if(auth()->user()) return $this->hasMany(Purchase::class)->where('user_id', '=', auth()->user()->id);
        else return $this->hasMany(Purchase::class);
    }
    
    public function sellings(){
        if(auth()->user()) return $this->hasMany(Selling::class)->where('user_id', '=', auth()->user()->id);
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
            $query->where('user_id', '=', auth()->user()->id)
                ->where('product_id', '=', $this->id);
        })->get()) >= 1;
    }

    public function createdBy(){
        $this->created = $this->created_by == auth()->user()->id;
    }

    public function setFirstPhoto(){
        $firstPhoto = $this->photos()->firstWhere('ordered', 1);
        $photo = ProductPhotoController::getPhotoLink($firstPhoto);
        if (is_null($firstPhoto)) {
            $linkPhoto = asset($photo);
        } else {
            $linkPhoto = asset(config('images.path_products').'/'.$this->id.'/'.$photo);
        }

        $this->pict = asset($linkPhoto);
    }

    public function description($length = 1000){
        $desc = substr($this->description, 0, $length) . (($length >= 1000)? '' : '...');
        return $desc;
    }
    
    public function bestWebsiteOffer(){
        $res = ['price' => $this->real_cost, 'url' => null, 'website_id' => null];
        foreach($this->getAvailableWebsites() as $offer){
            if($offer->price <= $res['price']){
                $res = ['price' => $offer->price, 'url' => $offer->url, 'website_id' => $offer->website_id];
            }
        }
        return (Object)array_merge($res, ['color' => ($res['price'] < $this->real_cost)? 'green' : (($res['price'] > $this->real_cost)? 'red' : 'black')]);
    }

    public function get_template(): object{
        $videoGame = ProductAsVideoGame::where('product_id', '=', $this->id)->first();
        if(!is_null($videoGame)) return (object)['type' => 'video_game', 'id' => $videoGame->id];

        $support = VgSupport::where('product_id', '=', $this->id)->first();
        if(!is_null($support)) return (object)['type' => 'vg_support', 'id' => $support->id];

        return (object)['type' => 'none', 'id' => null];
    }
}
