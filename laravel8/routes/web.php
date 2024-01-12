<?php
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductPhotoController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\ProductWebsiteController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\GroupBuyController;
use App\Http\Controllers\SellingController;
use App\Http\Controllers\ProductStateController;
use App\Http\Controllers\SellStateController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FriendUserController;
use App\Http\Controllers\CssColorController;
use App\Http\Controllers\ListingMessagesController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\ScriptsController;
use App\Http\Controllers\UtilsController;
use App\Http\Controllers\VgSupportController;
use App\Http\Controllers\VgDeveloperController;
use App\Http\Controllers\VideoGameController;

Route::get('/', function () {return view('welcome');})->name('home');
Route::get('/sitemap', function () {return view('sitemap');})->name('sitemap');

Route::get('user/{id}/profile', [FriendUserController::class, 'get_profile'])->name('get_user_profile');
Route::get('user/friends', [FriendUserController::class, 'index'])->name('my_friends');
Route::get('user/request/user/{id}/befriend', [FriendUserController::class, 'requesting'])->name('friend_requesting');
Route::get('user/friends/{id}/remove', [FriendUserController::class, 'remove'])->name('remove_friend');
Route::get('user/{user_id}/request/friend/{friend_id}/{status}', [FriendUserController::class, 'end_request'])->name('friend_request_end');
Route::post('friends/filter', [FriendUserController::class, 'filter'])->name('friends_search');
Route::get('user/friends/add', [FriendUserController::class, 'create'])->name('user_add_friend');

Route::get('user/benefits', [UserController::class, 'benefits'])->name('user_benefits');
Route::post('user/benefits', [UserController::class, 'filter_benefits'])->name('post_user_benefits');

Route::post('user/historic', [UserController::class, 'filter_historic'])->name('post_user_historic');
Route::get('user/historic/{kind}', [UserController::class, 'historic'])->middleware(['auth', 'verified'])->name('user_historic');

Route::get('products/{id}/follow', [ProductController::class, 'follow'])->name('follow_product');
Route::get('products/{id}/archive', [ProductController::class, 'archive'])->name('archive_product');
Route::post('products/filter', [ProductController::class, 'filter'])->name('products_search');
Route::post('products/bookmark', [ProductController::class, 'bookmark'])->name('product_bookmark');
Route::get('products/{id}/picture', [ProductController::class, 'get_picture'])->name('products.get_picture');

Route::get('products/user', [ProductController::class, 'index'])->middleware(['auth', 'verified'])->name('my_products');
Route::resource('products', ProductController::class)->middleware(['auth', 'verified'])->except(['destroy']);
Route::get('products/{product}/notifications/{notification}', [ProductController::class, 'showFromNotification'])->middleware(['auth', 'verified'])->name('products.showFromNotification');
Route::get('notifications/{id}/delete', [NotificationsController::class, 'delete'])->middleware(['auth', 'verified'])->name('delete_notif');

Route::get('products/{product}/photos/edit', [ProductPhotoController::class, 'edit'])->name('product_photos.edit');
Route::put('products/{product}/photos', [ProductPhotoController::class, 'update'])->name('product_photos.update');

Route::get('products/{product}/website/create', [ProductWebsiteController::class, 'create'])->name('product_websites.create');
Route::post('products/{product}/website', [ProductWebsiteController::class, 'store'])->name('product_websites.store');
Route::post('product_website/url/find', [ProductWebsiteController::class, 'find_by_url'])->name('find_by_url');
Route::get('product_website/{product_website}/edit', [ProductWebsiteController::class, 'edit'])->name('product_websites.edit');
Route::put('product_website/{product_website}', [ProductWebsiteController::class, 'update'])->name('product_websites.update');

Route::resource('purchases', PurchaseController::class)->except(['index', 'create', 'destroy']);
Route::get('products/{product?}/purchase/create', [PurchaseController::class, 'create'])->name('purchases.create');
Route::get('purchases/{purchase}/destroy', [PurchaseController::class, 'destroy'])->name('purchases.destroy');

Route::resource('group_buys', GroupBuyController::class)->except(['index', 'show', 'destroy']);
Route::get('group_buys/offer/{nb}/product/{id}/datas', [GroupBuyController::class, 'get_product_datas'])->name('group_buys.get_product_datas');
Route::get('user/{user_id}/group_buys/products/{nb}', [GroupBuyController::class, 'get_products'])->name('group_buys.get_products');
Route::get('group_buys/{group_buy}/destroy', [GroupBuyController::class, 'destroy'])->name('group_buys.destroy');

Route::resource('sellings', SellingController::class)->except(['index', 'create', 'destroy']);
Route::get('sellings/purchase/{purchase}/create', [SellingController::class, 'create'])->name('sellings.create');
Route::get('sellings/{selling}/destroy', [SellingController::class, 'destroy'])->name('sellings.destroy');

Route::get('lists/users/{user_id?}', [ListingController::class, 'get_user_lists'])->name('show_user_lists');
Route::get('lists/{id}/products/show', [ListingController::class, 'show_products'])->name('show_list_products');
Route::post('lists/products/search', [SearchController::class, 'search_products'])->name('list_search_products');
Route::post('lists/toggle_product', [ListingController::class, 'toggle_product'])->name('toggle_product_on_list');
Route::resource('lists', ListingController::class)->middleware(['auth', 'verified'])->except(['destroy']);
Route::get('lists/{id}/destroy', [ListingController::class, 'destroy'])->name('destroy_list');
Route::get('lists/{id}/download', [ListingController::class, 'download'])->name('download_list');
Route::get('shared/lists/{id}/show', [ListingController::class, 'show_share'])->name('show_share_list');
Route::post('lists/share', [ListingController::class, 'share'])->name('share_list');
Route::get('lists/{list_id}/leave', [ListingController::class, 'leave'])->name('leave_friend_list');
Route::post('lists/messages/send', [ListingMessagesController::class, 'send'])->name('send_message');
Route::get('lists/messages/{id}/delete', [ListingMessagesController::class, 'delete'])->name('list_delete_message');
Route::get('lists/messages/{id}/{action}', [ListingMessagesController::class, 'pin'])->name('pin_message');
Route::get('lists/{id}/delete/messages', [ListingMessagesController::class, 'delete_all'])->name('list_delete_all_messages');
Route::get('lists/{id}/messages/show/{pinned}', [ListingMessagesController::class, 'show'])->name('show_messages');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::post('color/variants', [CssColorController::class, 'get_variants'])->name('get_color_variants');

//Help sidebar
Route::post('benefit', [UtilsController::class, 'simulate_benefit'])->name('simulate_benefit');

Route::get('autocomplete', [SearchController::class, 'autocomplete'])->name('autocomplete');

Route::resource('video_games', VideoGameController::class)->middleware(['auth', 'verified'])->except(['destroy']);
Route::post('video_games/filter', [VideoGameController::class, 'filter'])->name('video_games_search');
Route::get('video_games/{vg_id}/vg_support/{vg_support_id?}/products/link', [UtilsController::class, 'lk_vg_to_product'])->name('vg_link_product');
Route::get('video_games/products/{id}/unlink', [VideoGameController::class, 'unlink_product'])->name('vg_unlink_product');

//Admin routes
Route::prefix('admin')->group(function () {
    Route::resource('websites', WebsiteController::class);
    Route::resource('tags', TagController::class);
    
    Route::resource('states/products', ProductStateController::class)
        ->parameters(['products' => 'product_state'])
        ->except(['show'])
        ->names([
        'index' => 'states.products.index',
        'create' => 'states.products.create',
        'store' => 'states.products.store',
        'edit' => 'states.products.edit',
        'update' => 'states.products.update',
        'destroy' => 'states.products.destroy',
    ]);

    Route::resource('states/sells', SellStateController::class)
        ->parameters(['sells' => 'sell_state'])
        ->except(['show'])
        ->names([
        'index' => 'states.sells.index',
        'create' => 'states.sells.create',
        'store' => 'states.sells.store',
        'edit' => 'states.sells.edit',
        'update' => 'states.sells.update',
        'destroy' => 'states.sells.destroy',
    ]);
    
    Route::resource('video_games/supports', VgSupportController::class)
        ->parameters(['supports' => 'vg_support'])
        ->except(['show'])
        ->names([
        'index' => 'vg_supports.index',
        'create' => 'vg_supports.create',
        'store' => 'vg_supports.store',
        'edit' => 'vg_supports.edit',
        'update' => 'vg_supports.update',
        'destroy' => 'vg_supports.destroy',
    ]);

    Route::resource('video_games/developers', VgDeveloperController::class)
        ->parameters(['developers' => 'vg_developer'])
        ->except(['show'])
        ->names([
        'index' => 'vg_developers.index',
        'create' => 'vg_developers.create',
        'store' => 'vg_developers.store',
        'edit' => 'vg_developers.edit',
        'update' => 'vg_developers.update',
        'destroy' => 'vg_developers.destroy',
    ]);
});

Route::get('scripts/video_games/product/link', [ScriptsController::class, 'lk_all_vg_to_product'])->name('script_lk_all_vg');

//Simple pages
Route::get('design-system', function() {
    return view("pages.design_system")->render();
})->middleware(['auth', 'verified'])->name('design_system');