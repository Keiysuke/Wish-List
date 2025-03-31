<?php

namespace App\Http\Requests;

use App\Models\Website;
use Illuminate\Foundation\Http\FormRequest;

class BookPublisherRequest extends FormRequest
{
    public function authorize(){
        return true;
    }

    public function rules(){
        $rules = [
            'label' => 'string|required|max:200',
            'description' => 'string|nullable|max:2500',
            'founded_year' => 'int|nullable|max:2500',
            'country' => 'string|max:100',
            'website_id' => 'int|required',
        ];
        return $rules;
    }

    protected function prepareForValidation(){
        // Recherche du site web à partir du label
        $website = Website::where('label', $this->input('label'))->first();

        if ($website) {// Ajoute l'id du site web dans la requête
            $this->merge([
                'website_id' => $website->id,
            ]);
        }
    }
    
    public function withValidator($validator){
        $validator->after(function ($validator) {
            if (!$this->input('website_id')) {// Vérifie si le site web a été trouvé après l'étape de validation
                $validator->errors()->add('website_id', __('No website found for this publisher. Please create it first.'));
            }
        });
    }
}
