<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TravelJourneyRequest extends FormRequest
{
    public function authorize(){
        return true;
    }

    public function rules(){
        $rules = [
            'user_id' => 'int|required',
            'label' => 'string|nullable|max:191',
            'max_nb_travel_steps' => 'int|required|min:1',
        ];
        for($i = 0; $i < $this->max_nb_travel_steps; $i++){
            $rules = array_merge($rules, [
                'travel_step_city_id_'.$i => 'int|required',
                'travel_step_start_date_'.$i => 'bail|date',
                'travel_step_end_date_'.$i => 'bail|date',
            ]);
        }
        return $rules;
    }
    
    public function messages()
    {
        return [
            'max_nb_travel_steps.min' => 'There must be at least one step.',
        ];
    }
}
