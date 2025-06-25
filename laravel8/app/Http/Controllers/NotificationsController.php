<?php

namespace App\Http\Controllers;

use App\Models\Crowdfunding;
use App\Models\CrowdfundingState;
use App\Models\Product;
use App\Models\User;
use App\Models\VideoGame;
use App\Notifications\MissingPhotos;
use App\Notifications\MissingProductOnVideoGame;
use App\Notifications\ProductSoonAvailable;
use App\Notifications\ProductSoonExpire;
use Carbon\Carbon;

class NotificationsController extends Controller
{
    public static function deleteFrom($kind, $customId){
        $user = User::find(auth()->user()->id);
        switch($kind){
            case 'MissingProductOnVideoGame':
                $notif = $user->notifications()->where('type', '=', 'App\Notifications\MissingProductOnVideoGame')->whereJsonContains('data->video_game_id', $customId)->first();
                break;
        }
        if(!is_null($notif)){
            $notif->delete();
        }
    }

    public function delete($id){
        $user = User::find(auth()->user()->id);
        $user->notifications()->find($id)->delete();

        return response()->json(['success' => true]);
    }

    public function checkProductNotifications(){
        $buildRequest = Product::query();
        $buildRequest->whereHas('productWebsites', function($query){
            $query->whereNotNull('available_date')
                ->orWhereNotNull('expiration_date');
        })->has('users');
        $products = $buildRequest->orderBy('label')->get();

        $today = Carbon::now();
        $checkDate = Carbon::now()->addDays(3);
        foreach($products as $product){
            foreach($product->productWebsites as $pw){
                //Notif all users if current date is 3 days or less, before the available/expired date
                if(!is_null($pw->available_date) && ($pw->available_date >= $today && $pw->available_date <= $checkDate)){
                    foreach($product->users as $user){
                        $exist = $user->notifications()->where('type', '=', 'App\Notifications\ProductSoonAvailable')->whereJsonContains('data->product_website_id', $pw->id)->first();
                        $days = Carbon::createFromFormat('Y-m-d H:i:s', $pw->available_date)->diffInDays($today);
                        //Updating the days number for notification or create a new one
                        if($exist && $days != $exist->data['days']) $exist->update(['data->days' => $days, 'read_at' => null]);
                        elseif(!$exist) $user->notify(new ProductSoonAvailable($pw, $user));
                    }
                }
                
                if(!is_null($pw->expiration_date) && ($pw->expiration_date >= $today && $pw->expiration_date <= $checkDate)){
                    foreach($product->users as $user){
                        $exist = $user->notifications()->where('type', '=', 'App\Notifications\ProductSoonExpire')->whereJsonContains('data->product_website_id', $pw->id)->first();
                        $days = Carbon::createFromFormat('Y-m-d H:i:s', $pw->expiration_date)->diffInDays($today);
                        //Updating the days number for notification or create a new one
                        if($exist && $days != $exist->data['days']) $exist->update(['data->days' => $days, 'read_at' => null]);
                        elseif(!$exist) $user->notify(new ProductSoonExpire($pw, $user));
                    }
                }
            }
        }
        $this->checkMissingPhotos();
    }

    public function checkMissingPhotos(){
        $buildRequest = Product::query();
        $buildRequest->doesntHave('photos');
        $products = $buildRequest->orderBy('label')->get();

        foreach($products as $product){
            $user = $product->creator();
            $exist = $user->notifications()->where('type', '=', 'App\Notifications\MissingPhotos')->whereJsonContains('data->product_id', $product->id)->first();
            if(!$exist) $user->notify(new MissingPhotos($product, $user));
        }
    }

    /** 
     * Video Games Notifications
    */
    
    public function checkVideoGameNotifications(){
        $this->checkMissingProduct();
    }

    public function checkMissingProduct(){
        $buildRequest = VideoGame::query();
        $buildRequest->doesntHave('products');
        $videoGames = $buildRequest->orderBy('label')->get();

        foreach($videoGames as $videoGame){
            $user = $videoGame->creator();
            $exist = $user->notifications()->where('type', '=', 'App\Notifications\MissingProductOnVideoGame')->whereJsonContains('data->video_game_id', $videoGame->id)->first();
            if(!$exist) $user->notify(new MissingProductOnVideoGame($videoGame, $user));
        }
    }

    /** 
     * Crowdfunding Notifications
    */
    
    public function checkCrowdfundingNotifications(){
        $buildRequest = Crowdfunding::query();
        $crowdfundings = $buildRequest->orderBy('project_name')->get();

        $today = Carbon::now();
        foreach($crowdfundings as $cf){
            $product = $cf->product;
            if(!$product) continue;
            $user = $product->creator();
            if(!$user || $cf->done()) continue;

            // 1. Début du crowdfunding (si la date est passée et pas encore notifié)
            if($cf->started()){
                $exist = $user->notifications()->where('type', '=', 'App\\Notifications\\CrowdfundingStart')->whereJsonContains('data->crowdfunding_id', $cf->id)->first();
                if(!$exist) $user->notify(new \App\Notifications\CrowdfundingStart($cf, $user));
                
                // 2. 1 semaine avant la fin de la campagne (si on est dans la dernière semaine et pas encore notifié)
                $end = Carbon::parse($cf->end_date);
                $oneWeekBefore = $end->copy()->subWeek();
                if($today->greaterThanOrEqualTo($oneWeekBefore) && $today->lessThanOrEqualTo($end)){
                    $exist = $user->notifications()->where('type', '=', 'App\\Notifications\\CrowdfundingEndSoon')->whereJsonContains('data->crowdfunding_id', $cf->id)->first();
                    if(!$exist) $user->notify(new \App\Notifications\CrowdfundingEndSoon($cf, $user));
                }
            }

            // 3. En attente de la date d'envoi des produits
            if($cf->waitForSend()){
                $exist = $user->notifications()->where('type', '=', 'App\\Notifications\\CrowdfundingWaitShipping')->whereJsonContains('data->crowdfunding_id', $cf->id)->first();
                if(!$exist) $user->notify(new \App\Notifications\CrowdfundingWaitShipping($cf, $user));
            }

            // 3. Date d'expédition passée (si la date est passée et pas encore notifié)
            if($cf->sending()){
                $exist = $user->notifications()->where('type', '=', 'App\\Notifications\\CrowdfundingShipped')->whereJsonContains('data->crowdfunding_id', $cf->id)->first();
                if(!$exist) $user->notify(new \App\Notifications\CrowdfundingShipped($cf, $user));
            }
        }
    }
}
