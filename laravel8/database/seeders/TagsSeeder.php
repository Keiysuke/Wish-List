<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TagsSeeder extends Seeder
{
    public function run()
    {
        \App\Models\Tag::create(['label' => 'Jeu Vidéo', 'css_color_id' => '7']);
        \App\Models\Tag::create(['label' => 'Jeu de Société', 'css_color_id' => '43']);
        \App\Models\Tag::create(['label' => 'Casse-tête', 'css_color_id' => '44']);
        \App\Models\Tag::create(['label' => 'Roman', 'css_color_id' => '46']);
        \App\Models\Tag::create(['label' => 'Bande dessinée', 'css_color_id' => '25']);
        \App\Models\Tag::create(['label' => 'Manga', 'css_color_id' => '17']);
        \App\Models\Tag::create(['label' => 'Accessoire', 'css_color_id' => '2']);
        \App\Models\Tag::create(['label' => 'Elétronique', 'css_color_id' => '41']);
        \App\Models\Tag::create(['label' => 'Figurine', 'css_color_id' => '63']);
    }
}
