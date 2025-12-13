<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class simulateWalkAppRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        return [
            'rising' => 'bail|numeric',
            'app' => 'bail|string|in:winwalk,macadam',
            'commission' => 'bail|nullable|boolean',
        ];
    }
}
