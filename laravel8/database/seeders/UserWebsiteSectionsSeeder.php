<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\UserWebsiteSection;

class UserWebsiteSectionsSeeder extends Seeder
{
    public function run()
    {
        UserWebsiteSection::create(['label' => 'Mes Favoris', 'icon' => 'svg.star', 'bg_css_color_id' => 42]);
        UserWebsiteSection::create(['label' => 'Mes Nouveautés', 'icon' => 'svg.big.bell', 'bg_css_color_id' => 8]);
        UserWebsiteSection::create(['label' => 'Mes applis', 'icon' => 'globe', 'bg_css_color_id' => 15]);
        UserWebsiteSection::create(['label' => 'Jeux Vidéo', 'icon' => 'svg.big.controller', 'bg_css_color_id' => 10]);
    }
}
