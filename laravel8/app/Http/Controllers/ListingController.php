<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\ListingProduct;
use App\Models\User;
use App\Http\Requests\ListingRequest;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    public function setProductsDatas(&$products){
        $products->total_price = 0;
        foreach($products as $product) $products->total_price += $product->real_cost * $product->nb;
    }

    public function toggle_product(Request $request){
        if ($request->ajax()) {
            $this->validate($request, [
                'list_id' => 'bail|required|int',
                'product_id' => 'bail|required|int',
                'nb' => 'bail|nullable|int',
                'change_checked' => 'bail|nullable|boolean'
            ]);
            
            if($request->change_checked) Listing::find($request->list_id)->products()->toggle([$request->product_id]);
            //Setting nb only if the product is still linked to that list
            $hasProduct = Listing::find($request->list_id)->products()->find($request->product_id);
            if($hasProduct && isset($request->nb)){
                ListingProduct::where('listing_id', '=', $request->list_id)
                    ->where('product_id', '=', $request->product_id)
                    ->update(['nb' => $request->nb]);
            }
            return response()->json(array('success' => true));
        }
    }

    public function show_products(Request $request){
        if ($request->ajax()) {
            $this->validate($request, ['list_id' => 'bail|required|int']);

            $list = Listing::find($request->list_id);
            $products = app('App\Http\Controllers\ProductController')->get_products($list->products()->paginate());
            
            foreach($products as $product) $product->nb = ListingProduct::where('product_id', '=', $product->id)->first()->nb;

            //Set the total price of all products in list
            $this->setProductsDatas($products);
            $returnHTML = view('lists.products.list')->with(['products' => $products, 'list' => $list])->render();
            return response()->json(['success' => true, 'nb_results' => $products->links()? $products->links()->paginator->total() : count($products), 'html' => $returnHTML]);
        }
    }

    public function index(){
        $lists = Listing::where('user_id', '=', auth()->user()->id)->orderBy('label')->get();
        return view('lists.index', compact('lists'));
    }

    public function create(){
        return view('lists.create');
    }

    public function store(ListingRequest $request){
        $list = new Listing([
            'user_id' => $request->user_id,
            'label' => $request->label,
            'description' => $request->description,
            'secret' => $request->has('secret')? 1 : 0,
        ]);
        $list->save();
        return redirect()->route('lists.index')->with('info', __('The list has been created.'));
    }

    public function show(Listing $list){
        //
    }

    public function edit(Listing $list){
        return view('lists.edit', compact('list'));
    }

    public function update(Request $request, Listing $list){
        $list->update($request
            ->merge(['label' => $request->label,
                'description' => $request->description,
                'secret' => ($request->has('secret')? 1 : 0)])
            ->all()
        );
        return redirect()->route('lists.index')->with('info', __('The list has been edited.'));
    }

    public function destroy(Listing $list){
        //Suppression des associations aux produits de la liste

        //Suppression des associations aux utilisateurs ayant accès à la liste
    }
}
