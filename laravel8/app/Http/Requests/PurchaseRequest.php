<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        if($this->add_selling){
            return [
                'user_id' => 'int|required',
                'product_id' => 'int|required',
                'product_state_id' => 'int|required',
                'website_id' => 'int|required',
                'cost' => 'required',
                'date' => 'required|date',
                'date_received' => 'required|date',
                'sell_product_state_id' => 'int|required',
                'sell_website_id' => 'int|required',
                'sell_state_id' => 'int|required',
                'price' => 'required',
                'confirmed_price' => 'nullable',
                'shipping_fees' => 'nullable',
                'shipping_fees_payed' => 'nullable',
                'nb_views' => 'int|nullable',
                'date_sold' => 'date|nullable',
                'date_send' => 'date|nullable',
            ];

        }else{
            return [
                'user_id' => 'int|required',
                'product_state_id' => 'int|required',
                'website_id' => 'int|required',
                'cost' => 'required',
                'date' => 'required|date',
                'date_received' => 'required|date',
            ];
        }
    }
}
