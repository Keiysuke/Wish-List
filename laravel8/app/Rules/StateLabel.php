<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class StateLabel implements Rule
{
    public function __construct()
    {
        //
    }

    public function passes($attribute, $value){
        return is_string($value) && !empty($value) && strlen($value) < 255;
    }

    public function message(){
        return 'L\'état doit être une chaine de max 255 caractères.';
    }
}
