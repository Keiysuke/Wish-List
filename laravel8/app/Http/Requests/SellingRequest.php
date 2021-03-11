<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SellingRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        return [
            'product_id' => 'int|required',
            'product_state_id' => 'int|required',
            'website_id' => 'int|required',
            'sell_state_id' => 'int|required',
            'price' => 'required',
            'confirmed_price' => 'nullable',
            'shipping_fees' => 'nullable',
            'shipping_fees_payed' => 'nullable',
            'nb_views' => 'int|nullable',
            'date_sold' => 'date|nullable',
            'date_send' => 'date|nullable',
        ];
    }
}
