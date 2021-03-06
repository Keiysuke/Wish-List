<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Product;
use App\Models\ProductPhoto;
use App\Models\Website;
use App\Models\ProductWebsite;
use App\Models\Purchase;
use App\Models\Selling;
use App\Models\ProductState;
use App\Models\SellState;
use App\Models\User;

class ViewServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
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
        View::composer(['partials.group_buy.select_offer'], function ($view) {
            $view->with('product_states', ProductState::all());
        });
        View::composer(['group_buys.create', 'group_buys.edit'], function ($view) {
            $view->with('products', User::find(\Auth::user()->id)->products()->orderBy('label')->get());
        });
    }
}
