<?php

namespace App\Http\Controllers;

use App\Models\BookPublisher;
use App\Models\Notyf;
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

    public function lkProductsToPublishers() {
        $publishers = BookPublisher::all();
        $nb = 0;
        foreach ($publishers as $publisher) {
            $nb += $publisher->fast_link_product();
        }
        return response()->json([
            'success' => true, 
            'notyf' => Notyf::success(__('Number of books created : ').$nb)
        ]);
    }
}
