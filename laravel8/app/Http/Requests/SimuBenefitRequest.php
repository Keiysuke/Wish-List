<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SimuBenefitRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        return [
            'payed' => 'bail|numeric',
            'sold' => 'bail|numeric',
            'commission' => 'bail|nullable|boolean',
        ];
    }
}
