<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        \App\Models\Website::create(['label' => 'Amazon', 'url' => 'https://www.amazon.fr/']);
        \App\Models\Website::create(['label' => 'eBay', 'url' => 'https://www.ebay.fr/']);
        \App\Models\Website::create(['label' => 'Cdiscount', 'url' => 'https://www.cdiscount.com/']);
        \App\Models\Website::create(['label' => 'Rakuten', 'url' => 'https://fr.shopping.rakuten.com/']);
        \App\Models\Website::create(['label' => 'Fnac', 'url' => 'https://www.fnac.com/']);
        \App\Models\Website::create(['label' => 'Groupon', 'url' => 'https://www.groupon.fr/']);
        \App\Models\Website::create(['label' => 'Ali Express', 'url' => 'https://fr.aliexpress.com/']);
        \App\Models\Website::create(['label' => 'Limited Run Games', 'url' => 'https://limitedrungames.com/']);
        \App\Models\Website::create(['label' => 'Omake books', 'url' => 'https://omakebooks.com/fr/']);
        \App\Models\Website::create(['label' => 'Cultura', 'url' => 'https://www.cultura.com/']);
        \App\Models\Website::create(['label' => 'Auchan', 'url' => 'https://www.auchan.fr/']);
        \App\Models\Website::create(['label' => 'Ultra Jeux', 'url' => 'https://www.ultrajeux.com/']);
        \App\Models\Website::create(['label' => 'Gen-cards', 'url' => 'https://www.gen-cards.com/']);
        \App\Models\Website::create(['label' => 'Zavvi', 'url' => 'https://fr.zavvi.com/']);
        \App\Models\Website::create(['label' => 'Kickstarter', 'url' => 'https://www.kickstarter.com/']);
        \App\Models\Website::create(['label' => 'Lego', 'url' => 'https://www.lego.com/fr-fr']);
        \App\Models\Website::create(['label' => 'Gentle Giant', 'url' => 'https://www.gentlegiantltd.com/']);

        $this->call([
            StatesSeeder::class,
            CrowdfundingSeeder::class,
        ]);
    }
}
