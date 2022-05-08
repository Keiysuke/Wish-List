<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VgSupportRequest extends FormRequest
{
    public function authorize(){
        return true;
    }

    public function rules(){
        $rules = [
            'product_id' => 'int|nullable',
            'label' => 'string|required',
            'alias' => 'string|nullable|max:10',
            'date_released' => 'date|required',
            'price' => 'numeric|required',
        ];
        return $rules;
    }
}
