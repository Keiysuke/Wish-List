<?php

namespace App\Services;

use App\Models\Selling;
use Illuminate\Http\Request;

class SellingService
{
    public function createFromRequest(Request $request): Selling
    {
        return Selling::create(
            $request->merge([
                'price' => str_replace(',', '.', $request->price),
                'confirmed_price' => is_null($request->confirmed_price)? $request->confirmed_price : str_replace(',', '.', $request->confirmed_price),
                'shipping_fees' => is_null($request->shipping_fees)? $request->shipping_fees : str_replace(',', '.', $request->shipping_fees),
                'shipping_fees_payed' => is_null($request->shipping_fees_payed)? $request->shipping_fees_payed : str_replace(',', '.', $request->shipping_fees_payed),
                'box' => $request->has('box')? 1 : 0,
            ])->all()
        );
    }
}