<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SimuDiscountRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        return [
            'price' => 'bail|numeric',
            'discount' => 'bail|numeric',
        ];
    }
}
