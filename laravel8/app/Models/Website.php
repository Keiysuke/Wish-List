<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductWebsite;
use App\Models\Purchase;
use App\Models\Selling;
use App\Models\Crowdfunding;

class Website extends Model
{
    use HasFactory;
    protected $fillable = ['label', 'url', 'icon', 'can_sell', 'is_vg', 'is_crowdfunding'];

    public function product_websites(){
        return $this->hasMany(ProductWebsite::class);
    }

    public function crowdfundings(){
        return $this->hasMany(Crowdfunding::class);
    }

    public function purchases(){
        return $this->hasMany(Purchase::class);
    }

    public function sellings(){
        return $this->hasMany(Selling::class);
    }

    public function publisher(){
        return $this->hasOne(Publisher::class);
    }

    public function asLink(){
        return '<a href="'.$this->url.'" class="link" target="_blank">'.$this->label.'</a>';
    }

    public static function parseUrl($url){
        $parsedUrl = parse_url($url);

        if (isset($parsedUrl['path'])) {// Vérifier si le chemin existe
            $newUrl = $parsedUrl['scheme'] . '://' . $parsedUrl['host'] . '/';
            return $newUrl;
        }
        return null;
    }

    public static function getCrowdfundingWebsites(){
        return self::where('is_crowdfunding', true)->pluck('id')->toArray();
    }
}
