<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductWebsiteRequest;
use App\Models\Product;
use App\Models\ProductWebsite;
use App\Models\Website;
use Carbon\Carbon;

class ProductWebsiteController extends Controller
{
    public function showAvailableDate($availableDate, $pastDate = false){
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

    //Routes
    public function create(Product $product){
        return view('products.websites.create', compact('product'));
    }

    public function store(ProductWebsiteRequest $request, Product $product){
        $productWebsite = new \App\Models\ProductWebsite([
            'product_id' => $product->id,
            'website_id' => $request->website_id,
            'price' => str_replace(',', '.', $request->price),
            'url' => $request->url,
            'available_date' => $request->available_date,
            'expiration_date' => $request->expiration_date
        ]);
        $productWebsite->save();
        return redirect()->route('products.show', $productWebsite->product_id)->with('info', __('The website has been linked to the product.'));
    }

    public function edit(ProductWebsite $productWebsite){
        return view('products.websites.edit', compact('productWebsite'));
    }
    
    public function update(ProductWebsiteRequest $request, ProductWebsite $productWebsite){
        $request->merge(['price' => str_replace(',', '.', $request->price)]);
        $productWebsite->update($request->all());
        return redirect()->route('products.show', $productWebsite->product_id)->with('info', __('The linked website has been edited.'));
    }

    public function findByUrl(Request $request){
        if ($request->ajax()) {
            $this->validate($request, [
                'url' => 'bail|required|string',
            ]);
            $url = Website::parseUrl($request->url);
            $ws = Website::where('url', '=', $url)->first();
            return response()->json(['success' => true, 'id' => (is_null($ws) ? 0 : $ws->id)]);
        }
    }
}
