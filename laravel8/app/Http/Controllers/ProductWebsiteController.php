<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductWebsiteRequest;
use App\Models\Product;
use App\Models\ProductWebsite;
use App\Models\Website;
use App\Services\ProductWebsiteService;

class ProductWebsiteController extends Controller
{
    //Routes
    public function create(Product $product){
        return view('products.websites.create', compact('product'));
    }

    public function store(ProductWebsiteRequest $request, Product $product){
        $productWebsiteService = new ProductWebsiteService();
        $productWebsiteService->createFromRequest($request, $product);
        return redirect()->route('products.show', $product->id)->with('info', __('The website has been linked to the product.'));
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
