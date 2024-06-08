<?php
namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use App\Services\DateService;
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
        $product->best_offer = $product->bestWebsiteOffer();
        $product->pict = asset(ProductPhotoController::getPhotoLink($product->photos->firstWhere('ordered', 1)));
        $today = DateService::today();
        return view('purchases.create', compact('product', 'today'));
    }

    public function store(PurchaseRequest $request){
        $this->validate($request, ['product_id' => 'int|required']); //Not required when updated the purchase
        $purchase = new Purchase([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'product_state_id' => $request->product_state_id,
            'website_id' => $request->website_id,
            'cost' => str_replace(',', '.', $request->cost),
            'date' => $request->date,
            'date_received' => $request->date_received,
        ]);
        $purchase->save();
        
        if($request->add_selling){ //On créé et lie également une vente
            $selling = new Selling([
                'user_id' => $request->user_id,
                'product_id' => $request->product_id,
                'product_state_id' => $request->sell_product_state_id,
                'purchase_id' => $purchase->id,
                'website_id' => $request->sell_website_id,
                'sell_state_id' => $request->sell_state_id,
                'price' => str_replace(',', '.', $request->price),
                'confirmed_price' => is_null($request->confirmed_price)? $request->confirmed_price : str_replace(',', '.', $request->confirmed_price),
                'shipping_fees' => is_null($request->shipping_fees)? $request->shipping_fees : str_replace(',', '.', $request->shipping_fees),
                'shipping_fees_payed' => is_null($request->shipping_fees_payed)? $request->shipping_fees_payed : str_replace(',', '.', $request->shipping_fees_payed),
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
        if($request->add_selling){
            $request->merge(['price' => str_replace(',', '.', $request->price),
                'confirmed_price' => is_null($request->confirmed_price)? $request->confirmed_price : str_replace(',', '.', $request->confirmed_price),
                'shipping_fees' => is_null($request->shipping_fees)? $request->shipping_fees : str_replace(',', '.', $request->shipping_fees),
                'shipping_fees_payed' => is_null($request->shipping_fees_payed)? $request->shipping_fees_payed : str_replace(',', '.', $request->shipping_fees_payed),
            ]);
        }
        $purchase->update($request
            ->merge(['cost' => str_replace(',', '.', $request->cost)])
            ->all()
        );
        return redirect()->route('products.show', $purchase->product_id)->with('info', __('The purchase has been edited.'));
    }

    public function destroy(Purchase $purchase){
        $product_id = $purchase->product_id;
        
        //Deleting Group_buys that only have that purchase as linked 
        foreach($purchase->group_buy_purchases()->get() as $groupBuyPurchase){
            if($groupBuyPurchase->group_buy()->first()->count_purchases() <= 1){
                $groupBuyPurchase->group_buy()->delete();
            }
        }

        $purchase->delete();
        return redirect()->route('products.show', $product_id)->with('info', __('The purchase has been deleted.'));
    }
}
