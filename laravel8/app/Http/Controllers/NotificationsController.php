<?php

namespace App\Http\Controllers;

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
}
