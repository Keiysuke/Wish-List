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
use App\Http\Controllers\SellingController;
use App\Http\Controllers\ProductStateController;
use App\Http\Controllers\SellStateController;

Route::get('/', function () {return view('welcome');})->name('home');
Route::get('/sitemap', function () {return view('sitemap');})->name('sitemap');

Route::post('products/follow', [ProductController::class, 'follow'])->name('follow_product');
Route::get('products/filter', [ProductController::class, 'index'])->name('products_search');
Route::post('products/filter', [ProductController::class, 'filter'])->name('products_search');
Route::post('products/bookmark', [ProductController::class, 'bookmark'])->name('product_bookmark');

Route::get('products/user', [ProductController::class, 'index'])->middleware(['auth', 'verified'])->name('my_products');
Route::resource('products', ProductController::class)->middleware(['auth', 'verified'])->except(['destroy']);
Route::get('products/{product}/notifications/{notification}', [ProductController::class, 'showFromNotification'])->middleware(['auth', 'verified'])->name('products.showFromNotification');

Route::get('products/{product}/photos/edit', [ProductPhotoController::class, 'edit'])->name('product_photos.edit');
Route::put('products/{product}/photos', [ProductPhotoController::class, 'update'])->name('product_photos.update');

Route::get('products/{product}/website/create', [ProductWebsiteController::class, 'create'])->name('product_websites.create');
Route::post('products/{product}/website', [ProductWebsiteController::class, 'store'])->name('product_websites.store');
Route::get('product_website/{product_website}/edit', [ProductWebsiteController::class, 'edit'])->name('product_websites.edit');
Route::put('product_website/{product_website}', [ProductWebsiteController::class, 'update'])->name('product_websites.update');

Route::resource('purchases', PurchaseController::class)->except(['index', 'create']);
Route::get('products/{product?}/purchase/create', [PurchaseController::class, 'create'])->name('purchases.create');
Route::resource('sellings', SellingController::class)->except(['index', 'create']);
Route::get('sellings/purchase/{purchase}/create', [SellingController::class, 'create'])->name('sellings.create');

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
