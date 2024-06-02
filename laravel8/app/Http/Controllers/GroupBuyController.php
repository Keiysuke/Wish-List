<?php
namespace App\Http\Controllers;

use App\Http\Requests\GroupBuyRequest;
use App\Models\GroupBuy;
use App\Models\GroupBuyPurchase;
use App\Models\ProductWebsite;
use App\Models\Purchase;
use App\Models\User;

class GroupBuyController extends Controller
{
    public function link_purchase($groupBuyId, $purchaseId){
        //Creating one if not already existing
        $existing = GroupBuyPurchase::where('group_buy_id', '=', $groupBuyId)->where('purchase_id', '=', $purchaseId)->get();
        if(count($existing) === 0){
            $groupBuyPurchase = new GroupBuyPurchase([
                'group_buy_id' => $groupBuyId,
                'purchase_id' => $purchaseId,
            ]);
            $groupBuyPurchase->save();
        }
    }

    public function unlink_purchase($groupBuyId, $purchaseId){
        GroupBuyPurchase::where('group_buy_id', '=', $groupBuyId)->where('purchase_id', '=', $purchaseId)->delete();
    }

    public function getProducts(int $userId, int $nb){
        $products = User::find($userId)->products()->orderBy('label')->get();
        $returnHTML = view('partials.group_buy.select_product', compact('nb', 'products'))->render();
        return response()->json(['success' => true, 'html' => $returnHTML]);
    }
    
    public function getProductDatas(int $nb, int $productId){
        //On récupère les offres du produit
        $offers = ProductWebsite::where('product_id', '=', $productId)->orderBy('price')->get();
        $offers = view('partials.group_buy.select_offer', compact('nb', 'offers'))->render();

        //puis les potentiels achats effectués
        $purchases = Purchase::where('product_id', '=', $productId)->orderBy('date')->get();
        $purchases = view('partials.group_buy.select_purchase', compact('nb', 'purchases'))->render();
        return response()->json(['success' => true, 'html' => compact('offers', 'purchases')]);
    }
    
    public function create(){
        return view('group_buys.create');
    }
    
    public function store(GroupBuyRequest $request){
        $groupBuy = new GroupBuy([
            'user_id' => $request->user_id,
            'label' => $request->label,
            'date' => $request->date,
            'global_cost' => 0,
            'discount' => str_replace(',', '.', $request->discount),
            'shipping_fees' => str_replace(',', '.', $request->shipping_fees),
        ]);
        $groupBuy->save();
        
        for($i = 0; $i < $request->max_nb_products; $i++){ //We loop on all the products
            if($request->has('product_bought_exists_'.$i)){ //An existing purchase was selected
                $this->link_purchase($groupBuy->id, $request->input('product_bought_purchase_id_'.$i));
                $p = Purchase::find($request->input('product_bought_purchase_id_'.$i));
                $groupBuy->global_cost += ($p->cost - $p->discount);

            }else{ //An existing offer was selected
                for($j = 0; $j < $request->input('product_bought_nb_'.$i); $j++){
                    //On récupère l'offre choisie
                    $offer = ProductWebsite::find($request->input('product_bought_offer_id_'.$i));
                    $purchase = new Purchase([
                        'user_id' => $request->user_id,
                        'product_id' => $request->input('product_bought_id_'.$i),
                        'product_state_id' => $request->input('product_bought_state_id_'.$i),
                        'website_id' => $offer->website->id,
                        'cost' => $offer->price,
                        'date' => $request->date,
                        'discount' => empty($request->input('product_bought_discount_'.$i))? 0 : $request->input('product_bought_discount_'.$i),
                        'customs' => $request->input('product_bought_customs_'.$i),
                    ]);
                    $purchase->save();
                    $this->link_purchase($groupBuy->id, $purchase->id);
                    
                    $groupBuy->global_cost += ($purchase->price - $purchase->discount);
                }
            }
        }
        $groupBuy->save();
        
        $info = __('The group buy has been created.');
        return redirect()->route('userHistoric', 'purchases')->with('info', $info);
    }
    
    public function edit(GroupBuy $groupBuy){
        $groupBuy->setDatas();
        return view('group_buys.edit', compact('groupBuy'));
    }
    
    public function update(GroupBuyRequest $request, GroupBuy $groupBuy){
        $groupBuy->update($request->merge([
            'label' => $request->label,
            'date' => $request->date,
            'global_cost' => 0,
            'discount' => str_replace(',', '.', $request->discount),
            'shipping_fees' => str_replace(',', '.', $request->shipping_fees),
            ])->all()
        );
        
        $purchases_to_link = [];
        for($i = 0; $i < $request->max_nb_products; $i++){
            if($request->has('product_bought_delete_'.$i)) //We delete the purchase from the group buy
                continue;
            
            if($request->has('product_bought_exists_'.$i)){
                $this->link_purchase($groupBuy->id, $request->input('product_bought_purchase_id_'.$i));
                $purchases_to_link[] = $groupBuy->id.'_'.$request->input('product_bought_purchase_id_'.$i);
                $p = Purchase::find($request->input('product_bought_purchase_id_'.$i));
                $groupBuy->global_cost += ($p->cost - $p->discount);
            }else{
                for($j = 0; $j < $request->input('product_bought_nb_'.$i); $j++){
                    //On récupère l'offre choisie
                    $offer = ProductWebsite::find($request->input('product_bought_offer_id_'.$i));
                    $purchase = new Purchase([
                        'user_id' => $request->user_id,
                        'product_id' => $request->input('product_bought_id_'.$i),
                        'product_state_id' => $request->input('product_bought_state_id_'.$i),
                        'website_id' => $offer->website->id,
                        'cost' => $offer->price,
                        'date' => $request->date,
                        'discount' => $request->input('product_bought_discount_'.$i),
                        'customs' => $request->input('product_bought_customs_'.$i),
                    ]);
                    $purchase->save();
                    $this->link_purchase($groupBuy->id, $purchase->id);
                    $purchases_to_link[] = $groupBuy->id.'_'.$purchase->id;

                    $groupBuy->global_cost += ($purchase->price - $purchase->discount);
                }
            }
            $groupBuy->save();
        }

        //We delete the previous linked purchases that has been edited/replaced
        foreach($groupBuy->group_buy_purchases as $gbp){
            if(!in_array($gbp->group_buy_id.'_'.$gbp->purchase_id, $purchases_to_link)){
                $this->unlink_purchase($gbp->group_buy_id, $gbp->purchase_id);
            }
        }
        
        //If there's no more buy linked, we delete the group buy
        if(!$groupBuy->has_purchases()){
            $groupBuy->delete();
        }
        
        $info = __('The group buy has been edited.');
        return redirect()->route('userHistoric', 'purchases')->with('info', $info);
    }
    
    public function destroy(GroupBuy $groupBuy){
        $groupBuy->delete();
        return redirect()->route('userHistoric', 'purchases')->with('info', __('The purchases\' group has been deleted.'));
    }
}
