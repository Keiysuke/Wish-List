<?php
namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use App\Services\DateService;
use App\Models\Purchase;
use App\Models\Product;
use App\Services\ProductService;
use App\Services\PurchaseService;
use App\Services\SellingService;

class PurchaseController extends Controller
{
    public function index(){
        $purchases = Purchase::all();
        return view('purchases.index', compact('purchases'));
    }

    public function create(Product $product){
        $product->best_offer = ProductService::bestWebsiteOffer($product);
        $product->setFirstPhoto();
        $today = DateService::today();
        return view('purchases.create', compact('product', 'today'));
    }

    public function store(PurchaseRequest $request){
        $this->validate($request, ['product_id' => 'int|required']); //Not required when updated the purchase
        $purchaseService = new PurchaseService();
        $purchase = $purchaseService->createFromRequest($request);
        
        if($request->add_selling){ //On créé aussi une vente
            $sellingService = new SellingService();
            $sellingService->createFromRequest($request->merge([
                'product_state_id' => $request->sell_product_state_id,
                'purchase_id' => $purchase->id,
                'website_id' => $request->sell_website_id,
            ]));
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
