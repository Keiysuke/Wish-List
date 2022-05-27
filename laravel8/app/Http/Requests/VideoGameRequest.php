<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VideoGameRequest extends FormRequest
{
    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'developer_id' => 'int|required',
            'label' => 'string|required',
            'date_released' => 'required|date',
            'nb_players' => 'int|required',
        ];
    }
}
