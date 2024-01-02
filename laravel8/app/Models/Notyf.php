<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notyf extends Model
{
    const SUCCESS = 'success';
    const ERROR = 'error';

    /**
    * Return a list of params to create a JS notyf
    * @param msg Text shown in the notif
    * @param kind Type of the notif (error, success...)
    * @param duration Time in miliseconds displaying the notif
    **/
    public static function get($msg, $kind = self::ERROR, $duration = 3000) {
        return [
            'position' => [
                'x' => 'right',
                'y' => 'top',
            ],
            'type' => $kind,
            'message' => __($msg),
            'duration' => $duration,
            'dismissible' => true,
        ];
    }
}
