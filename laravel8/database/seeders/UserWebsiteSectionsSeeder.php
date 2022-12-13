<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\UserWebsiteSection;

class UserWebsiteSectionsSeeder extends Seeder
{
    public function run()
    {
        UserWebsiteSection::create(['label' => 'Mes Favoris', 'icon' => 'star', 'bg_css_color_id' => 42]);
        UserWebsiteSection::create(['label' => 'Mes Nouveautés', 'icon' => 'bell', 'bg_css_color_id' => 8]);
    }
}
