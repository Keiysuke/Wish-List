<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductService
{
    public function createFromRequest(Request $request, $check = true): Product
    {
        if ($check && $this->exists($request->label)) {
            throw new \Exception(__('That product already exists.'));
        }

        return Product::create($request->merge([
            'real_cost' => str_replace(',', '.', $request->real_cost),
        ])->all());
    }

    public function exists(string $label): bool
    {
        return Product::where('label', $label)->exists();
    }

    public function setProductWebsites(&$products){
        foreach($products as $product){
            $product->nb_offers = count(ProductService::getAvailableWebsites($product));
            $product->can_buy = $product->nb_offers > count($product->getWebsitesAvailableSoon());
            $product->date_show = null;
            $product->bought = count($product->purchases) >= 1;

            if($product->nb_offers > 0){ //Des offres sont disponibles
                if($product->can_buy){
                    if($product->bought){
                        $product->date_show = __('Purchased on').' '.date('d/m/Y', strtotime($product->purchases()->orderBy('date')->first()->date));
                    }else{
                        //On affiche la date d'expiration la plus proche
                        $nextExpiration = $product->getwebsitesExpirationSoon()->first();
                        if(is_null($nextExpiration)) $product->date_show = __('Not bought');
                        else $product->date_show = __('An offer expire on').' '.ProductWebsiteService::showAvailableDate($nextExpiration->expiration_date);
                    }
                }else{ //Les offres sont pour des dates futures
                    $offer = $product->getWebsitesAvailableSoon()->first();
                    $product->date_show = ProductWebsiteService::showAvailableDate($offer->available_date);
                }
            }else $product->date_show = __('No offer listed');
        }
    }

    public function setProductPurchases(&$products){
        foreach($products as $product){
            $product->url = route('products.show', $product->id);
            $product->setFirstPhoto();
            $product->description = strlen($product->description) > 450 ? substr($product->description, 0, 450).'...': $product->description;
            $product->nb_purchases = count($product->purchases);
            $product->nb_resells = 0;
            foreach($product->sellings as $selling){
                if($selling->isSold()) $product->nb_resells++;
            }
            $product->nb_sellings = count($product->sellings)-$product->nb_resells;
        }
    }

    public static function getAvailableWebsites($product){
        return $product->productWebsites()
        ->where(function($query){
            $query->where('available_date', '<=', date("Y-m-d"))
                ->orWhereNull('available_date')
                ->orWhere('available_date', '>', date("Y-m-d"));
        })->where(function($query){
            $query->where('expiration_date', '>', date("Y-m-d"))
                ->orWhereNull('expiration_date');
        })->orderBy('available_date')->get();
    }

    public static function bestWebsiteOffer($product){
        $res = ['price' => $product->real_cost, 'url' => null, 'website_id' => null];
        foreach(self::getAvailableWebsites($product) as $offer){
            if($offer->price <= $res['price']){
                $res = [
                    'price' => $offer->price, 
                    'url' => $offer->url, 
                    'website_id' => $offer->website_id
                ];
            }
        }
        return (Object)array_merge($res, ['color' => ($res['price'] < $product->real_cost)? 'green' : (($res['price'] > $product->real_cost)? 'red' : 'black')]);
    }
}