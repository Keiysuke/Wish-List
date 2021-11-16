<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        return [
            'label' => 'string|required|max:50',
            'border_color' => 'string|required',
            'border_variant' => 'string|required',
            'text_color' => 'string|required',
            'text_variant' => 'string|required',
            'bg_color' => 'string|required',
            'bg_variant' => 'string|required',
        ];
    }
}
