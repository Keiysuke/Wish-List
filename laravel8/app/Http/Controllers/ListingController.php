<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\ListingProduct;
use App\Models\ListingUser;
use App\Models\User;
use App\Http\Requests\ListingRequest;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    public function toggle_product(Request $request){
        if ($request->ajax()) {
            $this->validate($request, [
                'list_id' => 'bail|required|int',
                'product_id' => 'bail|required|int',
                'nb' => 'bail|nullable|int',
                'change_checked' => 'bail|nullable|boolean'
            ]);

            $list = Listing::find($request->list_id);
            if($request->change_checked) $list->products()->toggle([$request->product_id]);
            //Setting nb only if the product is still linked to that list
            $products = $list->getProducts(false);
            $hasProduct = $products->find($request->product_id);
            if($hasProduct && isset($request->nb)){
                ListingProduct::where('listing_id', '=', $request->list_id)
                    ->where('product_id', '=', $request->product_id)
                    ->update(['nb' => $request->nb]);
            }
            
            $products = $list->getProducts();
            return response()->json(array('success' => true, 'total_price' => $products->total_price));
        }
    }

    public function show_products(Request $request){
        if ($request->ajax()) {
            $this->validate($request, ['list_id' => 'bail|required|int']);

            $list = Listing::find($request->list_id);
            $products = $list->getProducts();
            $returnHTML = view('lists.products.list')->with(compact('products', 'list'))->render();
            return response()->json(['success' => true, 'nb_results' => $products->links()? $products->links()->paginator->total() : count($products), 'html' => $returnHTML]);
        }
    }

    public function index(){
        $lists = Listing::where('user_id', '=', auth()->user()->id)
            ->orderBy('listing_type_id')
            ->orderBy('label')
            ->get();
        return view('lists.index', compact('lists'));
    }

    public function create(){
        return view('lists.create');
    }

    public function store(ListingRequest $request){
        $list = new Listing([
            'user_id' => $request->user_id,
            'listing_type_id' => $request->listing_type_id,
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
            ->merge(['listing_type_id' => $request->listing_type_id,
                'label' => $request->label,
                'description' => $request->description,
                'secret' => ($request->has('secret')? 1 : 0)])
            ->all()
        );
        return redirect()->route('lists.index')->with('info', __('The list has been edited.'));
    }

    public function destroy(Request $request){
        if ($request->ajax()) {
            $this->validate($request, ['id' => 'bail|required|int']);
            $list = Listing::find($request->id);
            foreach($list->products as $product){ //Suppression des associations aux produits de la liste
                ListingProduct::where('listing_id', '=', $list->id)->where('product_id', '=', $product->id)->delete();
            }
            foreach($list->users as $user){ //Suppression des associations aux utilisateurs ayant accès à la liste
                ListingUser::where('listing_id', '=', $list->id)->where('user_id', '=', $user->id)->delete();
            }
            $list->delete();
            $first_list = Listing::where('user_id', '=', auth()->user()->id)->orderBy('label')->first();
            $list_id = is_null($first_list)? -1 : $first_list->id;
            return response()->json(['success' => true, 'deleted_id' => $request->id, 'list_id' => $list_id]);
        }
    }

    public function download(Request $request){
        if ($request->ajax()) {
            $this->validate($request, ['id' => 'bail|required|int']);
            $products = Listing::find($request->id)->getProducts();
            return response()->json(['success' => true, 'blob' => view('exports.list', compact('products'))->render()]);
        }
    }
}
