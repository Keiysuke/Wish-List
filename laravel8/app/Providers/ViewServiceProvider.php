<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Website;
use App\Models\UserWebsite;
use App\Models\ProductState;
use App\Models\SellState;
use App\Models\User;
use App\Models\Tag;
use App\Models\CssColor;
use App\Models\VgDeveloper;
use App\Models\VgSupport;

class ViewServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        View::composer(['*'], function ($view) {
            $view->with('user_websites', UserWebsite::where('user_id', '=', \Auth::user()->id)->orderBy('favorite_order')->get());
        });
        View::composer(['products.websites.create', 'products.websites.edit', 'products.create'], function ($view) {
            $view->with('websites', Website::orderBy('label')->get());
        });
        View::composer(['purchases.create', 'purchases.edit'], function ($view) {
            $view->with('websites', Website::orderBy('label')->get());
            $view->with('product_states', ProductState::all());
            $view->with('sell_states', SellState::all());
        });
        View::composer(['sellings.create', 'sellings.edit'], function ($view) {
            $view->with('websites', Website::where('can_sell', '=', '1')->orderBy('label')->get());
            $view->with('product_states', ProductState::all());
            $view->with('sell_states', SellState::all());
        });
        View::composer(['products.index'], function ($view) {
            $view->with('websites', Website::orderBy('label')->get());
        });
        View::composer(['products.create'], function ($view) {
            $view->with('product_states', ProductState::all());
        });
        View::composer(['products.create', 'products.edit', 'products.index'], function ($view) {
            $view->with('tags', Tag::orderBy('label')->get());
        });
        View::composer(['partials.group_buy.select_offer'], function ($view) {
            $view->with('product_states', ProductState::all());
        });
        View::composer(['group_buys.create', 'group_buys.edit'], function ($view) {
            $view->with('products', User::find(\Auth::user()->id)->products()->orderBy('label')->get());
        });
        
        //Video Games Section
        View::composer(['video_games.create', 'video_games.edit', 'video_games.index'], function ($view) {
            $view->with('developers', VgDeveloper::orderBy('label')->get());
        });
        View::composer(['video_games.index'], function ($view) {
            $view->with('developers', VgDeveloper::orderBy('label')->get());
            $view->with('vg_supports', VgSupport::orderBy('label')->get());
        });
        
        //Admin
        View::composer(['partials.tags.edit_colors'], function ($view) {
            $view->with('unique_colors', CssColor::unique_colors());
        });
    }
}
