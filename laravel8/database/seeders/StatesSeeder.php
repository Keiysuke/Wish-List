<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class StatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\ProductState::create(['label' => 'Neuf']);
        \App\Models\ProductState::create(['label' => 'Occasion']);
        \App\Models\ProductState::create(['label' => 'Correct']);
        \App\Models\ProductState::create(['label' => 'Comme neuf']);

        \App\Models\SellState::create(['label' => 'A mettre en vente']);
        \App\Models\SellState::create(['label' => 'En vente']);
        \App\Models\SellState::create(['label' => 'Vendu']);
        \App\Models\SellState::create(['label' => 'Envoyé']);
        \App\Models\SellState::create(['label' => 'Terminée']);
    }
}
