<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WebsiteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'label' => 'string|required|max:50',
            'url' => 'string|required|between:3,100'
        ];
    }
}
