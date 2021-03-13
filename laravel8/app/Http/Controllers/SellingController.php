<?php
namespace App\Http\Controllers;

use App\Http\Requests\SellingRequest;
use App\Models\Selling;
use App\Models\Purchase;

class SellingController extends Controller
{
    public function index(){
        $sellings = Selling::all();
        return view('sellings.index', compact('sellings'));
    }
    
    public function create(Purchase $purchase){
        return view('sellings.create', compact('purchase'));
    }

    public function store(SellingRequest $request){
        $this->validate($request, ['purchase_id' => 'int|required']); //Not required when updated the selling
        $selling = new Selling([
            'product_id' => $request->product_id,
            'product_state_id' => $request->product_state_id,
            'purchase_id' => $request->purchase_id,
            'website_id' => $request->website_id,
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
        return redirect()->route('products.show', $selling->product_id)->with('info', __('The selling has been created.'));
    }

    public function edit(Selling $selling){
        return view('sellings.edit', compact('selling'));
    }

    public function update(SellingRequest $request, Selling $selling){
        $selling->update($request
            ->merge(['price' => str_replace(',', '.', $request->price), 
                'confirmed_price' => is_null($request->confirmed_price)? $request->confirmed_price : str_replace(',', '.', $request->confirmed_price),
                'shipping_fees' => is_null($request->shipping_fees)? $request->shipping_fees : str_replace(',', '.', $request->shipping_fees),
                'shipping_fees_payed' => is_null($request->shipping_fees_payed)? $request->shipping_fees_payed : str_replace(',', '.', $request->shipping_fees_payed),
                'box' => ($request->has('box')? 1 : 0)])
            ->all()
        );
        return redirect()->route('products.show', $selling->product_id)->with('info', __('The selling has been edited.'));
    }

    public function destroy(Selling $selling){
        $selling->delete();
        return back()->with('info', __('The selling has been deleted.'));
    }
}
