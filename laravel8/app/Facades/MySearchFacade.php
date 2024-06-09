<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class MySearchFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Services\SearchService::class;
    }
}
