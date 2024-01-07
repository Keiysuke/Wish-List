<?php

namespace App\Http\Controllers;

use App\Models\VideoGame;
use Illuminate\Http\Request;

class UtilsController extends Controller
{
    public function simulate_benefit(Request $request){
        if ($request->ajax()) {
            $this->validate($request, [
                'payed' => 'bail|numeric',
                'sold' => 'bail|numeric',
                'commission' => 'bail|nullable|boolean',
            ]);
            $benefit = $request->sold - $request->payed;
            if($request->commission) $benefit -= self::getCommission($request->sold);
            return response()->json(['success' => true, 'req' => $request->all(), 'benefit' => round($benefit, 4)]);
        }
        abort(404);
    }

    public static function getCommission($price){
        //Old
        // $price_sold -= ($price*3.05)/100;
        // $price_sold -= (((($s->confirmed_price* 8) / 100)* 20) / 100) + (($s->confirmed_price* 8) / 100);
        //New
        return ($price*11.08)/100;
    }

    public static function psthc($search, $support = 'ps4') {
        $replace = [
            ' ' => '-', 
            "&#039;s" => '', 
            ':' => '',
            'of ' => '',
        ];
        $search = strtolower(strtr($search, $replace));
        $s = '';
        foreach(explode('-', $search) as $term){
            if(!strcmp($term, intval($term))) $s .= $term;
            else $s .= $term.'-';
        }
        return 'https://www.psthc.fr/unjeu/' . $s . strtolower($support);
    }

    public function lk_vg_to_product(int $vg_id, int $vg_support_id = 0){
        $vg_support_id = $vg_support_id == 0 ? null : $vg_support_id;
        $vg = VideoGame::find($vg_id);
        return response()->json($vg->fast_link_product($vg_support_id));
    }

    public static function cutString($msg, $siz = 1000){
        $etc = (strlen($msg) > $siz) ? '...' : '';
        return substr($msg, 0, $siz) . $etc;
    }
}
