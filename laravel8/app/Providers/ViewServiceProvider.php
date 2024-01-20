<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Website;
use App\Models\UserWebsite;
use App\Models\ProductState;
use App\Models\Listing;
use App\Models\ListingType;
use App\Models\SellState;
use App\Models\User;
use App\Models\Tag;
use App\Models\CssColor;
use App\Models\Emoji;
use App\Models\VgDeveloper;
use App\Models\VgSupport;
use App\Services\NotificationService;
use App\Models\Notyf;
use App\Models\EmojiSection;
use App\Services\DesignService;
use App\Services\EmojiService;

class ViewServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        View::composer(['*'], function ($view) {
            $user_websites = [];
            if (auth()->check()) {
                $user_websites = UserWebsite::where('user_id', '=', auth()->user()->id)->orderBy('user_website_section_id')->orderBy('ordered')->get();
            }
            $sections = [];
            foreach ($user_websites as $user_website) {
                if (array_key_exists($user_website->user_website_section_id, $sections)) {
                    $sections[$user_website->user_website_section_id][] = $user_website;
                } else {
                    $sections[$user_website->user_website_section_id] = [$user_website];
                }
            }
            $view->with('user_website_sections', $sections);
        });
        View::composer(['components.notif'], function ($view) {
            $view->with(['kinds' => NotificationService::KINDS]);
        });
        View::composer(['partials.lists.messages'], function ($view) {
            $view->with(['emoji_off' => Emoji::findSpecific(), 'emoji_on' => Emoji::findSpecific('kbd_on')]);
        });
        View::composer(['partials.messages.emoji_keyboard'], function ($view) {
            $view->with(['sections' => EmojiSection::orderBy('id')->get()]);
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
        View::composer(['products.index', 'users.benefits'], function ($view) {
            $view->with('websites', Website::orderBy('label')->get());
        });
        View::composer(['products.create'], function ($view) {
            $view->with('product_states', ProductState::all());
        });
        View::composer(['products.create', 'products.edit', 'products.index', 'users.benefits'], function ($view) {
            $view->with('tags', Tag::orderBy('label')->get());
        });
        View::composer(['lists.create', 'lists.edit'], function ($view) {
            $view->with('listing_types', ListingType::orderBy('label')->get());
        });
        View::composer(['lists.index'], function ($view) {
            $lists = Listing::where('user_id', '=', auth()->user()->id)->orderBy('listing_type_id')->orderBy('label')->get();
            $view->with('lists', $lists);
        });
        View::composer(['partials.group_buy.select_offer'], function ($view) {
            $view->with('product_states', ProductState::all());
        });
        View::composer(['group_buys.create', 'group_buys.edit'], function ($view) {
            $view->with('products', User::find(auth()->user()->id)->products()->orderBy('label')->get());
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

        View::composer(['admin.emojis.create', 'admin.emojis.edit'], function ($view) {
            $view->with('sections', EmojiSection::all());
        });

        //Pages
        View::composer(['pages.design_system'], function ($view) {
            $icons = [
                'min' => DesignService::getIconsAsComponent(),
                'big' => DesignService::getIconsAsComponent('big')
            ];
            $emojis = Emoji::all();
            $colors = DesignService::getColors();
            
            $notifications = NotificationService::getExistingNotifications();
            $notyfs = [];
            foreach (Notyf::KINDS as $kind) {
                $notyfs[$kind] = (Object)['id' => $kind, 'label' => $kind];
            }
            $view->with(compact('icons', 'emojis', 'notifications', 'notyfs', 'colors'));
        });
    }
}
