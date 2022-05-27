<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\VgDeveloper;
use \App\Models\VideoGame;
use \App\Models\ProductAsVideoGame;

class VgDevelopersSeeder extends Seeder
{
    public function run()
    {
        // VgDeveloper::create(['label' => 'Naughty Dog', 'description' => "Société américaine de développement de jeu vidéo domiciliée à Santa Monica, fondée en 1984 par Andy Gavin et Jason Rubin sous le nom de JAM Software, avant d'être rebaptisé Naughty Dog en 1989", 'year_created' => 1984]);
        // VideoGame::create(['developer_id' => 1, 'label' => 'Uncharted: The Lost Legacy', 'date_released' => '2017-08-22', 'nb_players' => 10]);
        ProductAsVideoGame::create(['product_id' => 21, 'video_game_id' => 1, 'vg_support_id' => 2]);
    }
}
