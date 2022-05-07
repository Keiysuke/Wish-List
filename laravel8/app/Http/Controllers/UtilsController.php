<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UtilsController extends Controller
{
    public function simulate_benefit(Request $request){
        if ($request->ajax()) {
            $this->validate($request, [
                'payed' => 'bail|numeric',
                'sold' => 'bail|numeric',
            ]);
            $benefit = ($request->sold - self::getCommission($request->sold)) - $request->payed;
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
}
