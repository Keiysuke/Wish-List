<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListingRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'int|required',
            'label' => 'string|required|max:100',
            'description' => 'string|nullable|max:1000'
        ];
    }
}
