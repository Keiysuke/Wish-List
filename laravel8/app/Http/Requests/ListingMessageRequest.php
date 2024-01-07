<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListingMessageRequest extends FormRequest
{
    public function authorize(){
        return true;
    }

    public function rules(){
        $rules = [
            'listing_id' => 'int|required',
            'message' => 'string|required|max:1000',
            'answer_to_id' => 'int|nullable',
        ];
        return $rules;
    }
}
