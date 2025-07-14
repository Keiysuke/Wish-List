<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PsnVgRequest extends FormRequest
{
    public function authorize(){
        return true;
    }

    public function rules(){
        
        $validator = [
            'ps_month' => 'required|integer|min:1|max:12', 
            'ps_year' => 'required|integer|min:2000|max:'.date('Y')
        ];
        for ($i = 0; $i < 3; $i++) {
            $validator['label_'.$i] = 'required|string|max:255';
            $validator['date_released_'.$i] = 'required|date';
            $validator['nb_players_'.$i] = 'nullable|integer';
            $validator['developer_id_'.$i] = 'int|nullable';
        }
        return $validator;
    }

    protected function prepareForValidation()
    {
        for ($i = 0; $i < 3; $i++) {
            if ($this->input('developer_id_'.$i) === 'to_create') {
                $this->merge([
                    'developer_id_'.$i => null,
                ]);
            }
        }
    }
}
