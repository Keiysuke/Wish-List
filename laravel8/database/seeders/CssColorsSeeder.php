<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CssColorsSeeder extends Seeder
{
    const COLORS = [
        'red', 
        'green',
        'blue',
        'indigo',
        'yellow',
        'pink',
        'purple',
        'gray',
        'blue_gray',
        'cool_gray',
        'true_gray',
        'warm_gray',
        'orange',
        'amber',
        'lime',
        'emerald',
        'teal',
        'cyan',
        'sky',
        'violet',
        'fuchsia',
        'rose',
    ];

    public function run()
    {
        \App\Models\CssColor::create(['css_class' => 'white', 'hexadecimal' => '']);
        \App\Models\CssColor::create(['css_class' => 'black', 'hexadecimal' => '']);
        foreach(self::COLORS as $color){
            for($i = 100; $i <= 900; $i += 100){
                \App\Models\CssColor::create(['css_class' => $color.'-'.$i, 'hexadecimal' => '']);
            }
        }
    }
}
