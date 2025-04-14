<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VgFilterRequest extends FormRequest
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
            'page' => 'bail|required|int',
            'purchased' => 'bail|required|string',
            'f_nb_results' => 'bail|required|int',
        ];
    }
}
