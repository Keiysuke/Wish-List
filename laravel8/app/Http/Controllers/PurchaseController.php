<?php
namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use App\Models\Purchase;
use App\Models\Selling;
use App\Models\Product;

class PurchaseController extends Controller
{
    public function index(){
        $purchases = Purchase::all();
        return view('purchases.index', compact('purchases'));
    }

    public function create(Product $product){
        return view('purchases.create', compact('product'));
    }

    public function store(PurchaseRequest $request){
        $this->validate($request, ['product_id' => 'int|required']); //Not required when updated the purchase
        $purchase = new Purchase([
            'product_id' => $request->product_id,
            'product_state_id' => $request->product_state_id,
            'website_id' => $request->website_id,
            'cost' => $request->cost,
            'date' => $request->date
        ]);
        $purchase->save();
        
        if($request->add_selling){ //On créé et lie également une vente
            $selling = new Selling([
                'product_id' => $request->product_id,
                'product_state_id' => $request->sell_product_state_id,
                'purchase_id' => $purchase->id,
                'website_id' => $request->sell_website_id,
                'sell_state_id' => $request->sell_state_id,
                'price' => $request->price,
                'confirmed_price' => $request->confirmed_price,
                'shipping_fees' => $request->shipping_fees,
                'shipping_fees_payed' => $request->shipping_fees_payed,
                'nb_views' => $request->nb_views,
                'date_begin' => $request->date_begin,
                'date_sold' => $request->date_sold,
                'date_send' => $request->date_send,
                'box' => $request->has('box')? 1 : 0,
            ]);
            $selling->save();
            
            $info = __('Purchase & selling has been created.');
        }

        return redirect()->route('products.show', $request->product_id)->with('info', __('The purchase has been created.'));
    }

    public function edit(Purchase $purchase){
        return view('purchases.edit', compact('purchase'));
    }

    public function update(PurchaseRequest $request, Purchase $purchase){
        $purchase->update($request->all());
        return redirect()->route('products.show', $purchase->product_id)->with('info', __('The purchase has been edited.'));
    }

    public function destroy(Purchase $purchase){
        $purchase->delete();
        return back()->with('info', __('The purchase has been deleted.'));
    }
}
