<?php

namespace App\Http\Controllers;

use App\Models\VideoGame;
use Illuminate\Http\Request;

class UtilsController extends Controller
{
    public function simulateBenefit(Request $request){
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

    public function linkVgToProduct(int $vgId, int $vgSupportId = 0){
        $vgSupportId = $vgSupportId == 0 ? null : $vgSupportId;
        $vg = VideoGame::find($vgId);
        return response()->json($vg->fast_link_product($vgSupportId));
    }

    public static function cutString($msg, $siz = 1000){
        $etc = (strlen($msg) > $siz) ? '...' : '';
        return substr($msg, 0, $siz) . $etc;
    }
}
