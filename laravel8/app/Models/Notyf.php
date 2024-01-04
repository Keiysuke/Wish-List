<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;

class Notyf extends Model
{
    const WARNING = 'warning';
    const SUCCESS = 'success';
    const ERROR = 'error';
    const DURATION = 3000;

    /** 
     * Return an array containing custom datas according to the kind parameter
     * @param kind Type of the notif (error, success...)
     * @return Array 
    */
    public static function getCustom($kind) {
        $custom = [];
        switch ($kind) {
            case self::WARNING : $custom = [
                    'background' => 'orange',
                    'icon' => Blade::compileString(view('components.svg.warning', ['attributes' => ''])),
                ];
                break;
        }
        return $custom;
    }

    /**
    * Return a list of params to create a JS notyf
    * @param msg Text shown in the notif
    * @param kind Type of the notif (error, success...)
    * @param duration Time in miliseconds displaying the notif
    **/
    public static function get($msg, $kind = self::ERROR, $duration = self::DURATION) {
        return array_merge(self::getCustom($kind), [
            'position' => [
                'x' => 'right',
                'y' => 'top',
            ],
            'type' => $kind,
            'message' => __($msg),
            'duration' => $duration,
            'dismissible' => true,
        ]);
    }

    public static function success($msg, $duration = self::DURATION) {
        return self::get($msg, self::SUCCESS, $duration);
    }

    public static function error($msg, $duration = self::DURATION) {
        return self::get($msg, self::ERROR, $duration);
    }

    public static function warning($msg, $duration = self::DURATION) {
        return self::get($msg, self::WARNING, $duration);
    }
}
