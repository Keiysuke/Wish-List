<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        \App\Models\Website::create(['label' => 'Amazon', 'url' => 'https://www.amazon.fr/']);
        \App\Models\Website::create(['label' => 'eBay', 'url' => 'https://www.ebay.fr/']);
        \App\Models\Website::create(['label' => 'Cdiscount', 'url' => 'https://www.cdiscount.com/']);
        \App\Models\Website::create(['label' => 'Rakuten', 'url' => 'https://fr.shopping.rakuten.com/']);
        \App\Models\Website::create(['label' => 'Fnac', 'url' => 'https://www.fnac.com/']);
        \App\Models\Website::create(['label' => 'Groupon', 'url' => 'https://www.groupon.fr/']);
        \App\Models\Website::create(['label' => 'Cultura', 'url' => 'https://www.cultura.com/']);
        \App\Models\Website::create(['label' => 'Auchan', 'url' => 'https://www.auchan.fr/']);

        $this->call([
            StatesSeeder::class,
        ]);
    }
}
