<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupBuyRequest extends FormRequest
{
    public function authorize(){
        return true;
    }

    public function rules(){
        $rules = [
            'user_id' => 'int|required',
            'label' => 'string|nullable|max:100',
            'date' => 'date|required',
            'shipping_fees' => 'required',
            'max_nb_products' => 'int|required|min:1',
        ];
        for($i = 0; $i < $this->max_nb_products; $i++){
            $rules = array_merge($rules, [
                'product_bought_offer_id_'.$i => 'int|required'
            ]);
        }
        return $rules;
    }
    
    public function messages()
    {
        return [
            'max_nb_products.min' => 'There must be at least one product.',
        ];
    }
}
