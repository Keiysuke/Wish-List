<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listing;
use App\Models\Product;

class SearchController extends Controller
{
    const NB_RESULTS = 8;

    public function search_products(Request $request){
        if ($request->ajax()) {
            $this->validate($request, [
                'list_id' => 'bail|nullable|int',
                'search' => 'bail|nullable|string'
                ]);

            $except_ids = [];
            if(!is_null($request->list_id)){ //We do not show the products that already are in the list
                $list = Listing::find($request->list_id);
                $products = app('App\Http\Controllers\ProductController')->get_products($list->products()->paginate());
                foreach($products as $product) $except_ids[] = $product->id;
            }

            //We keep only the products with matching labels
            $products = Product::select('label')
                ->whereNotIn('id', $except_ids)
                ->where('label', 'LIKE', "%{$request->search}%")
                ->orderBy('label')->take($this::NB_RESULTS)->get();

            return response()->json(['success' => true, 'result' => $products]);
        }
    }
}
