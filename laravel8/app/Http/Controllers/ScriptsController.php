<?php

namespace App\Http\Controllers;

use App\Models\VideoGame;

class ScriptsController extends Controller
{
    public function lk_all_vg_to_product() {
        $video_games = VideoGame::all();
        foreach ($video_games as $video_game) {
            $res = $video_game->fast_link_product();
            var_dump($res);
        }
    }
}
