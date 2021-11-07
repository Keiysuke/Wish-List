<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(){
        return true;
    }

    public function rules(){
        $rules = [
            'label' => 'string|required|max:100',
            'description' => 'string|nullable|max:1000',
            'limited_edition' => 'nullable|digits_between:1,5',
            'real_cost' => 'required',
        ];
        if($this->add_purchase){
            $rules = array_merge($rules, 
            ['website_id' => 'int|required',
                'price' => 'required',
                'url' => 'string|nullable',
                'expiration_date' => 'date|nullable',
                'product_state_id' => 'int|required',
                'cost' => 'required',
                'date' => 'required|date',
            ]);
        }
        //A la création, on oblige la présence de l'upload de la photo mais pas à l'édition
        if($this->has('expiration_date')) $rules['photo_1'] = 'image|required';
        return $rules;
    }
}
