<?php
namespace App\Http\Controllers;

use App\Http\Requests\GroupBuyRequest;
use App\Models\GroupBuy;
use App\Models\GroupBuyPurchase;
use App\Models\Product;
use App\Models\ProductWebsite;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Http\Request;

class GroupBuyController extends Controller
{
    public function link_purchase($group_buy_id, $purchase_id){
        //Creating one if not already existing
        $existing = GroupBuyPurchase::where('group_buy_id', '=', $group_buy_id)->where('purchase_id', '=', $purchase_id)->get();
        if(count($existing) === 0){
            $group_buy_purchase = new GroupBuyPurchase([
                'group_buy_id' => $group_buy_id,
                'purchase_id' => $purchase_id,
            ]);
            $group_buy_purchase->save();
        }
    }

    public function unlink_purchase($group_buy_id, $purchase_id){
        GroupBuyPurchase::where('group_buy_id', '=', $group_buy_id)->where('purchase_id', '=', $purchase_id)->delete();
    }

    public function get_products(Request $request){
        if ($request->ajax()) {
            $this->validate($request, [
                'nb' => 'bail|required|int',
                'user_id' => 'bail|required|int',
            ]);
            $nb = $request->nb;
            $user_id = $request->user_id;

            $products = User::find($user_id)->products()->orderBy('label')->get();
            $returnHTML = view('partials.group_buy.select_product', compact('nb', 'products'))->render();
            return response()->json(['success' => true, 'html' => $returnHTML]);
        }
    }
    
    public function get_product_datas(Request $request){
        if ($request->ajax()) {
            $this->validate($request, [
                'nb' => 'bail|required|int',
                'product_id' => 'bail|required|int',
            ]);
            $nb = $request->nb;
            $product_id = $request->product_id;

            //On récupère les offres du produit
            $offers = ProductWebsite::where('product_id', '=', $product_id)->orderBy('price')->get();
            $offers = view('partials.group_buy.select_offer', compact('nb', 'offers'))->render();

            //puis les potentiels achats effectués
            $purchases = Purchase::where('product_id', '=', $product_id)->orderBy('date')->get();
            $purchases = view('partials.group_buy.select_purchase', compact('nb', 'purchases'))->render();
            return response()->json(['success' => true, 'html' => compact('offers', 'purchases')]);
        }
    }
    
    public function create(){
        return view('group_buys.create');
    }
    
    public function store(GroupBuyRequest $request){
        $group_buy = new GroupBuy([
            'user_id' => $request->user_id,
            'label' => $request->label,
            'date' => $request->date,
            'global_cost' => $request->global_cost,
            'discount' => $request->discount,
            'shipping_fees' => $request->shipping_fees,
        ]);
        $group_buy->save();
        
        for($i = 0; $i < $request->max_product_nb; $i++){
            if($request->has('product_bought_existing_'.$i)){
                $this->link_purchase($group_buy->id, $request->input('product_bought_purchase_id_'.$i));
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
                        'discount' => empty($request->input('product_bought_discount_'.$i))? 0 : $request->input('product_bought_discount_'.$i),
                        'customs' => $request->input('product_bought_customs_'.$i),
                    ]);
                    $purchase->save();
                    $this->link_purchase($group_buy->id, $purchase->id);
                }
            }
        }
        
        $info = __('The group buy has been created.');
        return redirect()->route('user_historic', 'purchases')->with('info', $info);
    }
    
    public function edit(GroupBuy $group_buy){
        $group_buy->setDatas();
        return view('group_buys.edit', compact('group_buy'));
    }
    
    public function update(GroupBuyRequest $request, GroupBuy $group_buy){
        $group_buy->update($request->merge([
            'label' => $request->label,
            'date' => $request->date,
            'global_cost' => $request->global_cost,
            'discount' => $request->discount,
            'shipping_fees' => $request->shipping_fees,])
            ->all()
        );
        
        $purchases_to_link = [];
        for($i = 0; $i < $request->max_product_nb; $i++){
            if($request->has('product_bought_delete_'.$i)) //We delete the purchase from the group buy
                continue;
            
            if($request->has('product_bought_existing_'.$i)){
                $this->link_purchase($group_buy->id, $request->input('product_bought_purchase_id_'.$i));
                $purchases_to_link[] = $group_buy->id.'_'.$request->input('product_bought_purchase_id_'.$i);
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
                    $this->link_purchase($group_buy->id, $purchase->id);
                    $purchases_to_link[] = $group_buy->id.'_'.$purchase->id;
                }
            }
        }

        //We delete the previous linked purchases that has been edited/replaced
        foreach($group_buy->group_buy_purchases as $gbp){
            if(!in_array($gbp->group_buy_id.'_'.$gbp->purchase_id, $purchases_to_link)){
                $this->unlink_purchase($gbp->group_buy_id, $gbp->purchase_id);
            }
        }
        
        //If there's no more buy linked, we delete the group buy
        if(!$group_buy->has_purchases()){
            $group_buy->delete();
        }
        
        $info = __('The group buy has been edited.');
        return redirect()->route('user_historic', 'purchases')->with('info', $info);
    }
    
    public function destroy(GroupBuy $group_buy){
        $group_buy->delete();
        return redirect()->route('user_historic', 'purchases')->with('info', __('The purchases\' group has been deleted.'));
    }
}
