<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listing;
use App\Models\Product;
use App\Models\VgSupport;
use App\Models\VideoGame;

class SearchController extends Controller
{
    const NB_RESULTS = 8;

    /**
     * Search and return products that are not already in the list
     */
    public function findOtherProducts(Request $request){
        if ($request->ajax()) {
            $this->validate($request, [
                'list_id' => 'bail|nullable|int',
                'search' => 'bail|nullable|string'
                ]);

            $exceptIds = [];
            if(!is_null($request->list_id)){ //We do not show the products that already are in the list
                $list = Listing::find($request->list_id);
                $products = (new ProductController)->getProducts($list->products()->paginate());
                foreach($products as $product) $exceptIds[] = $product->id;
            }

            //We keep only the products with matching labels
            $products = Product::select('label')
                ->whereNotIn('id', $exceptIds)
                ->where('label', 'LIKE', "%{$request->search}%")
                ->orderBy('label')->take($this::NB_RESULTS)->get();

            return response()->json(['success' => true, 'result' => $products]);
        }
    }

    public function autocomplete(Request $request)
    {
        $data = [];
        if($request->filled('q')){
            switch($request->searchDataType){
                case 'video_game':
                    $data = VideoGame::select("label", "id")
                        ->where('label', 'LIKE', '%'. $request->get('q'). '%')
                        ->get();
                    break;
                case 'vg_support':
                    $data = VgSupport::select("label", "alias", "id")
                        ->where('label', 'LIKE', '%'. $request->get('q'). '%')
                        ->Orwhere('alias', 'LIKE', '%'. $request->get('q'). '%')
                        ->get();
                    break;
            }
        }
        return response()->json($data);
    }
}
