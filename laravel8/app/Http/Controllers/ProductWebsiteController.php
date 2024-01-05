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
    public function showAvailableDate($available_date, $past_date = false){
        if(is_null($available_date)) return '';
        $days = Carbon::createFromFormat('Y-m-d H:i:s', $available_date)->diffInDays(Carbon::now());

        if($days > 180){
            $date = $past_date ? 'depuis le ' : 'le ';
            $date .= date('d/m/Y', strtotime($available_date));
        }elseif($days >= 2){
            $date = $past_date ? 'depuis ' : 'dans ';
            $date .= " $days jours";
        }elseif($days > 1 || date('d', strtotime($available_date)) != date('d')){
            $date = $past_date ? 'depuis hier ' : 'demain à ';
            $date .= date('H:i', strtotime($available_date));
        }else{
            $date = $past_date ? 'depuis aujourd\'hui ' : 'à ';
            $date .= date('H:i', strtotime($available_date));
        }
        return $date;
    }

    //Routes
    public function create(Product $product){
        return view('products.websites.create', compact('product'));
    }

    public function store(ProductWebsiteRequest $request, Product $product){
        $product_website = new \App\Models\ProductWebsite([
            'product_id' => $product->id,
            'website_id' => $request->website_id,
            'price' => str_replace(',', '.', $request->price),
            'url' => $request->url,
            'available_date' => $request->available_date,
            'expiration_date' => $request->expiration_date
        ]);
        $product_website->save();
        return redirect()->route('products.show', $product_website->product_id)->with('info', __('The website has been linked to the product.'));
    }

    public function edit(ProductWebsite $product_website){
        return view('products.websites.edit', compact('product_website'));
    }
    
    public function update(ProductWebsiteRequest $request, ProductWebsite $product_website){
        $request->merge(['price' => str_replace(',', '.', $request->price)]);
        $product_website->update($request->all());
        return redirect()->route('products.show', $product_website->product_id)->with('info', __('The linked website has been edited.'));
    }

    public function find_by_url(Request $request){
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
