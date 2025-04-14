<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductFilterRequest extends FormRequest
{
    public function authorize(){
        return true;
    }
    
    public function rules()
    {
        return [
            'search_text' => 'bail|nullable|string',
            'sort_by' => 'bail|required|string',
            'order_by' => 'bail|required|string',
            'list' => 'bail|required|string',
            'show_archived' => 'bail|required|int',
            'page' => 'bail|required|int',
            'stock' => 'bail|required|string',
            'purchased' => 'bail|required|string',
            'f_nb_results' => 'bail|required|int',
            'tag_in' => 'bail|int',
        ];
    }
}
