<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VideoGameRequest extends FormRequest
{
    public function authorize(){
        return true;
    }

    public function rules(){
        
        return [
            'developer_id' => 'int|nullable',
            'label' => 'string|required',
            'date_released' => 'required|date',
            'nb_players' => 'int|required',
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->input('developer_id') === 'to_create') {
            $this->merge([
                'developer_id' => null,
            ]);
        }
    }
}
