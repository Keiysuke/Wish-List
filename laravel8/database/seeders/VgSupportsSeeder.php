<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\VgSupport;

class VgSupportsSeeder extends Seeder
{
    public function run()
    {
        VgSupport::create(['label' => 'Ordinateur', 'alias' => 'PC', 'date_released' => '1981-08-12', 'price' => '1484']);
        VgSupport::create(['label' => 'Playsation 4', 'alias' => 'PS4', 'date_released' => '2013-11-15', 'price' => '350']);
        VgSupport::create(['label' => 'Playsation 5', 'alias' => 'PS5', 'date_released' => '2020-11-19', 'price' => '499']);
        VgSupport::create(['label' => 'Nintendo Switch', 'alias' => 'Switch', 'date_released' => '2017-03-03', 'price' => '330']);
        VgSupport::create(['label' => 'New Nintendo 3DS', 'alias' => 'n3DS', 'date_released' => '2015-02-13', 'price' => '169']);
        VgSupport::create(['label' => 'New Nintendo 3DS XL', 'alias' => 'n3DS XL', 'date_released' => '2015-02-13', 'price' => '199']);
        VgSupport::create(['label' => 'Nintendo 3DS', 'alias' => '3DS', 'date_released' => '2011-02-26', 'price' => '220']);
    }
}
