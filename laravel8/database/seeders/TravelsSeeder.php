<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TravelsSeeder extends Seeder
{
    public function run()
    {
        // Pays connus
        $countries = [
            ['id' => 1, 'name' => 'France', 'code' => 'FRA'],
            ['id' => 2, 'name' => 'États-Unis', 'code' => 'USA'],
            ['id' => 3, 'name' => 'Japon', 'code' => 'JPN'],
            ['id' => 4, 'name' => 'Italie', 'code' => 'ITA'],
            ['id' => 5, 'name' => 'Espagne', 'code' => 'ESP'],
        ];
        DB::table('countries')->insert($countries);

        // Villes connues (exemple, à compléter)
        $cities = [
            ['id' => 1, 'name' => 'Paris', 'postal_code' => '75000', 'country_id' => 1],
            ['id' => 2, 'name' => 'New York', 'postal_code' => '10001', 'country_id' => 2],
            ['id' => 3, 'name' => 'Tokyo', 'postal_code' => '100-0001', 'country_id' => 3],
            ['id' => 4, 'name' => 'Rome', 'postal_code' => '00100', 'country_id' => 4],
            ['id' => 5, 'name' => 'Barcelone', 'postal_code' => '08001', 'country_id' => 5],
        ];
        DB::table('cities')->insert($cities);

        // Types de spot
        $spotTypes = [
            ['id' => 1, 'label' => 'Musée'],
            ['id' => 2, 'label' => 'Parc'],
            ['id' => 3, 'label' => 'Hôtel'],
            ['id' => 4, 'label' => 'Restaurant'],
            ['id' => 5, 'label' => 'Monument'],
        ];
        DB::table('spot_types')->insert($spotTypes);
    }
}
