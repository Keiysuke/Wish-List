<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(){
        return true;
    }

    public function rules(){
        $rules = [
            'label' => 'string|required|max:100',
            'description' => 'string|nullable|max:2500',
            'limited_edition' => 'nullable|digits_between:1,5',
            'real_cost' => 'required',
        ];
        if($this->add_purchase){
            $rules = array_merge($rules, 
            ['website_id' => 'int|required',
                'price' => 'required',
                'url' => 'string|nullable',
                'expiration_date' => 'date|nullable',
                'product_state_id' => 'int|required',
                'cost' => 'required',
                'date' => 'required|date',
            ]);
        }
        
        //A l'édition, il est possible d'associer un support ou jeu vidéo au produit
        if($this->has('template_type') && $this->template_type !== 'none'){
            switch($this->template_type){
                case 'video_game':
                    $rules = array_merge($rules, 
                    ['lk_video_game' => 'int|required',
                        'lk_vg_support' => 'int|required',
                    ]);
                    break;
                case 'vg_support':
                    $rules = array_merge($rules, ['lk_vg_support' => 'int|required']);
                    break;
                case 'publisher':
                    $rules = array_merge($rules, ['lk_publisher' => 'int|required']);
                    break;
            }
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'lk_video_game.required' => 'You must choose a video game',
            'lk_vg_support.required' => 'You must choose a support',
            'lk_publisher.required' => 'You must choose a publisher',
        ];
    }
}
