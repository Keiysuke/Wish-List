<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Notifications\ProductSoonAvailable;
use App\Notifications\ProductSoonExpire;
use Carbon\Carbon;
use EloquentBuilder;

class NotificationsController extends Controller
{
    public function checkProductNotifications(){
        $buildRequest = Product::query();
        $buildRequest->whereHas('productWebsites', function($query){
            $query->whereNotNull('available_date')
                ->orWhereNotNull('expiration_date');
        })->has('users');
        $products = $buildRequest->orderBy('label')->get();

        $today = Carbon::now();
        $check_date = Carbon::now()->subDays(3);
        foreach($products as $product){
            foreach($product->productWebsites as $pw){
                //Notif all users if current date is 3 days or less, before the available/expired date
                if(!is_null($pw->available_date) && ($pw->available_date <= $today && $pw->available_date >= $check_date)){
                    foreach($product->users as $user){
                        $exist = $user->notifications()->whereJsonContains('data->product_website_id', $pw->id)->first();
                        //Updating the days number for notification or create a new one
                        if($exist) $exist->update(['data->days' => Carbon::createFromFormat('Y-m-d H:i:s', $pw->available_date)->diffInDays($today)]);
                        else $user->notify(new ProductSoonAvailable($pw, $user));
                    }
                }
                
                if(!is_null($pw->expiration_date) && ($pw->expiration_date >= $today && $pw->expiration_date >= $check_date)){
                    foreach($product->users as $user){
                        $exist = $user->notifications()->whereJsonContains('data->product_website_id', $pw->id)->first();
                        //Updating the days number for notification or create a new one
                        if($exist) $exist->update(['data->days' => Carbon::createFromFormat('Y-m-d H:i:s', $pw->expiration_date)->diffInDays($today)]);
                        else $user->notify(new ProductSoonExpire($pw, $user));
                    }
                }
            }
        }
    }
}
