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

    public function linkVgToProduct(int $vgId, int $vgSupportId = 0){
        $vgSupportId = $vgSupportId == 0 ? null : $vgSupportId;
        $vg = VideoGame::find($vgId);
        return response()->json($vg->fast_link_product($vgSupportId));
    }

    public static function cutString($msg, $siz = 1000){
        $etc = (strlen($msg) > $siz) ? '...' : '';
        return substr($msg, 0, $siz) . $etc;
    }

    public static function checkKeyExistingInArray($tab, $find){
        foreach ($tab as $k => $v) {
            if (strpos($k, $find) === 0) {
                return true;
            }
        }
        return false;
    }

    public static function getPriceColor($price, $real_cost){
        return ($price < $real_cost) ? 'green' : (($price > $real_cost) ? 'red' : 'black');
    }

    public static function asId($s){
        return str_replace('_', '-', $s);
    }
}
