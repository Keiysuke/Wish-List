<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VgDeveloperRequest extends FormRequest
{
    public function authorize(){
        return true;
    }

    public function rules(){
        $rules = [
            'label' => 'string|required',
            'description' => 'string|nullable|max:1000',
            'year_created' => 'int|required|max:2500',
        ];
        return $rules;
    }
}
