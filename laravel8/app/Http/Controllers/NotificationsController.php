<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Notifications\ProductSoonAvailable;
use App\Notifications\ProductSoonExpire;
use Carbon\Carbon;

class NotificationsController extends Controller
{
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
    }
}
