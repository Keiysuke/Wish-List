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
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\ProductWebsiteController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\GroupBuyController;
use App\Http\Controllers\SellingController;
use App\Http\Controllers\ProductStateController;
use App\Http\Controllers\SellStateController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;

Route::get('/', function () {return view('welcome');})->name('home');
Route::get('/sitemap', function () {return view('sitemap');})->name('sitemap');

Route::post('user/historic', [UserController::class, 'filter_historic'])->name('post_user_historic');
Route::get('user/historic/{kind}', [UserController::class, 'historic'])->name('user_historic');

Route::post('products/follow', [ProductController::class, 'follow'])->name('follow_product');
Route::get('products/filter', [ProductController::class, 'index'])->name('products_search');
Route::post('products/filter', [ProductController::class, 'filter'])->name('products_search');
Route::post('products/bookmark', [ProductController::class, 'bookmark'])->name('product_bookmark');
Route::post('products/picture', [ProductController::class, 'get_picture'])->name('products.get_picture');

Route::get('products/user', [ProductController::class, 'index'])->middleware(['auth', 'verified'])->name('my_products');
Route::resource('products', ProductController::class)->middleware(['auth', 'verified'])->except(['destroy']);
Route::get('products/{product}/notifications/{notification}', [ProductController::class, 'showFromNotification'])->middleware(['auth', 'verified'])->name('products.showFromNotification');

Route::get('products/{product}/photos/edit', [ProductPhotoController::class, 'edit'])->name('product_photos.edit');
Route::put('products/{product}/photos', [ProductPhotoController::class, 'update'])->name('product_photos.update');

Route::get('products/{product}/website/create', [ProductWebsiteController::class, 'create'])->name('product_websites.create');
Route::post('products/{product}/website', [ProductWebsiteController::class, 'store'])->name('product_websites.store');
Route::get('product_website/{product_website}/edit', [ProductWebsiteController::class, 'edit'])->name('product_websites.edit');
Route::put('product_website/{product_website}', [ProductWebsiteController::class, 'update'])->name('product_websites.update');

Route::resource('purchases', PurchaseController::class)->except(['index', 'create', 'destroy']);
Route::get('products/{product?}/purchase/create', [PurchaseController::class, 'create'])->name('purchases.create');
Route::get('purchases/{purchase}/destroy', [PurchaseController::class, 'destroy'])->name('purchases.destroy');

Route::resource('group_buys', GroupBuyController::class)->except(['index', 'show', 'destroy']);
Route::post('group_buys/product/get_datas', [GroupBuyController::class, 'get_product_datas'])->name('group_buys.get_product_datas');
Route::post('group_buys/get_products', [GroupBuyController::class, 'get_products'])->name('group_buys.get_products');
Route::get('group_buys/{group_buy}/destroy', [GroupBuyController::class, 'destroy'])->name('group_buys.destroy');

Route::resource('sellings', SellingController::class)->except(['index', 'create', 'destroy']);
Route::get('sellings/purchase/{purchase}/create', [SellingController::class, 'create'])->name('sellings.create');
Route::get('sellings/{selling}/destroy', [SellingController::class, 'destroy'])->name('sellings.destroy');

Route::post('lists/show_products', [ListingController::class, 'show_products'])->name('show_list_products');
Route::post('lists/search_products', [SearchController::class, 'search_products'])->name('list_search_products');
Route::post('lists/toggle_product', [ListingController::class, 'toggle_product'])->name('toggle_product_on_list');
Route::resource('lists', ListingController::class)->middleware(['auth', 'verified']);

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

//Admin routes
Route::prefix('admin')->group(function () {
    Route::resource('websites', WebsiteController::class);
    
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
});
