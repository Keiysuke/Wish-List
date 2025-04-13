<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductWebsite;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductWebsiteService
{
    public function createFromRequest(Request $request, Product $product): ProductWebsite
    {
        return ProductWebsite::create(
            $request->merge([
                'product_id' => $product->id,
                'price' => str_replace(',', '.', $request->price),
            ])->all()
        );
    }
    
    public static function showAvailableDate($availableDate, $pastDate = false){
        if(is_null($availableDate)) return '';
        $days = Carbon::createFromFormat('Y-m-d H:i:s', $availableDate)->diffInDays(Carbon::now());

        if($days > 180){
            $date = $pastDate ? 'depuis le ' : 'le ';
            $date .= date('d/m/Y', strtotime($availableDate));
        }elseif($days >= 2){
            $date = $pastDate ? 'depuis ' : 'dans ';
            $date .= " $days jours";
        }elseif($days > 1 || date('d', strtotime($availableDate)) != date('d')){
            $date = $pastDate ? 'depuis hier ' : 'demain à ';
            $date .= date('H:i', strtotime($availableDate));
        }else{
            $date = $pastDate ? 'depuis aujourd\'hui ' : 'à ';
            $date .= date('H:i', strtotime($availableDate));
        }
        return $date;
    }
}