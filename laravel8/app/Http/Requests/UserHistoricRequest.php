<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserHistoricRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        return [
            'user_id' => 'bail|required|int',
            'date_from' => 'bail|nullable|date',
            'date_to' => 'bail|nullable|date',
            'kind' => 'bail|required|string',
        ];
    }
}
