<?php

namespace App\Http\Controllers;

use App\Http\Requests\SimuBenefitRequest;
use App\Http\Requests\SimuDiscountRequest;
use App\Models\Product;
use App\Models\VgSupport;
use App\Models\VideoGame;
use App\Models\Website;
use App\Services\ProductWebsiteService;
use App\Services\PurchaseService;

class UtilsController extends Controller
{
    public function simulateBenefit(SimuBenefitRequest $request){
        abort_unless($request->ajax(), 404);
        $benefit = $request->sold - $request->payed;
        if($request->commission) $benefit -= self::getCommission($request->sold);
        return response()->json(['success' => true, 'req' => $request->all(), 'benefit' => round($benefit, 4)]);
    }

    public function simulateDiscount(SimuDiscountRequest $request){
        abort_unless($request->ajax(), 404);
        $percent = (($request->price - ($request->price - $request->discount)) / $request->price) * 100;
        return response()->json(['success' => true, 'req' => $request->all(), 'percent' => round($percent, 4)]);
    }

    public static function getCommission($price){
        //Old
        // $price_sold -= ($price*3.05)/100;
        // $price_sold -= (((($s->confirmed_price* 8) / 100)* 20) / 100) + (($s->confirmed_price* 8) / 100);
        //New
        return ($price*11.08)/100;
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

    /** 
     * Link a video game to a product, or create the product if it does not exist
     * @param int $vgId
     * @param int $vgSupportId
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
    */
    public static function linkVgToProduct(int $vgId, int $vgSupportId = 0){
        $vgSupportId = $vgSupportId == 0 ? null : $vgSupportId;
        $vg = VideoGame::find($vgId);
        return response()->json($vg->fast_link_product($vgSupportId));
    }

    /** 
     * Create or link a product for a PS Plus video game. Then create a purchase for it
     * @param VideoGame $videoGame
     * @param int $month
     * @param int $year
     * @return void
    */
    public static function createProductFromPsPlus($videoGame, $month, $year){
        $userId = auth()->user()->id;
        //We create a product for the video game on the PS4 support & PS website
        $ps4 = VgSupport::where('alias', 'PS4')->first();
        $psWebsite = Website::where('label', 'Playstation')->first();
        $response = self::linkVgToProduct($videoGame->id, $ps4->id);
        //If the product was not created, we create it
        if(!$response->getData()->success) {
            $product = Product::create([
                'label' => $videoGame->label.' - '.$ps4->alias,
                'real_cost' => '0',
                'created_by' => $userId,
            ]);
            //We link it to the current user
            $product->users()->attach($userId);
            $response = self::linkVgToProduct($videoGame->id, $ps4->id);

            if(!$response->getData()->success) {
                throw new \Exception('Could not link the video game to the product');
            }
        }

        $product = $product ?? Product::where('id', $response->getData()->productId)->first();
        //We also create a website offer for the product
        (new ProductWebsiteService())->createFromRequest(new \Illuminate\Http\Request([
            'product_id' => $product->id,
            'website_id' => $psWebsite->id,
            'price' => 0,
        ]), $product);

        $date = $year.'-'.$month.'-01';
        //And a purchase for the product
        (new PurchaseService())->createFromRequest(new \Illuminate\Http\Request([
            'user_id' => $userId,
            'product_id' => $product->id,
            'product_state_id' => 1,
            'website_id' => $psWebsite->id,
            'cost' => 0,
            'date' => $date,
            'date_received' => $date,
        ]));
    }
}
