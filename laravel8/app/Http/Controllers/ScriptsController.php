<?php

namespace App\Http\Controllers;

use App\Models\VideoGame;

class ScriptsController extends Controller
{
    public function lkAllVgToProduct() {
        $videoGames = VideoGame::all();
        foreach ($videoGames as $videoGame) {
            $res = $videoGame->fast_link_product();
            var_dump($res);
        }
    }
}
