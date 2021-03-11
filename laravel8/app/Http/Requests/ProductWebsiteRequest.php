<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductWebsiteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'website_id' => 'int|required',
            'price' => 'required',
            'url' => 'string|nullable',
            'available_date' => 'date|nullable',
            'expiration_date' => 'date|nullable'
        ];
    }
}
