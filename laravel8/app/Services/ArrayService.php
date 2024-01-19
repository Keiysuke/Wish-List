<?php

namespace App\Services;

use stdClass;

class ArrayService
{
    public static function toObject(Array $array): Object
    {
        if (empty($array)) {
            return new stdClass;
        }
        return json_decode(json_encode($array));
    }
}

