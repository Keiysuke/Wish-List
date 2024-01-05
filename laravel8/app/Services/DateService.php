<?php

namespace App\Services;

use Carbon\Carbon;

class DateService
{
    public static function today($format = 'Y-m-d'){
        return Carbon::now()->format($format);
    }

    public static function getDate($date, $format = 'd/m/Y'){
        return is_null($date)? '' : date($format, strtotime($date));
    }
}
