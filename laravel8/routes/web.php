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
use App\Http\Controllers\EmojiController;
use App\Http\Controllers\ListingMessagesController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\ScriptsController;
use App\Http\Controllers\EmojiSectionController;
use App\Http\Controllers\ListMsgReactionsController;
use App\Http\Controllers\UtilsController;
use App\Http\Controllers\VgSupportController;
use App\Http\Controllers\VgDeveloperController;
use App\Http\Controllers\VideoGameController;

Route::get('/', function () {return view('welcome');})->name('home');
Route::get('/sitemap', function () {return view('sitemap');})->name('sitemap');

Route::get('user/{id}/profile', [FriendUserController::class, 'getProfile'])->name('getUserProfile');
Route::get('user/friends', [FriendUserController::class, 'index'])->name('myFriends');
Route::get('user/request/user/{friendId}/befriend', [FriendUserController::class, 'requesting'])->name('friendRequesting');
Route::get('user/friends/{id}/remove', [FriendUserController::class, 'remove'])->name('removeFriend');
Route::get('user/{userId}/request/friend/{friendId}/{status}', [FriendUserController::class, 'endRequest'])->name('friendRequestEnd');
Route::post('user/friends/filter', [FriendUserController::class, 'filter'])->name('friendsSearch');
Route::get('user/friends/add', [FriendUserController::class, 'create'])->name('userAddFriend');

Route::get('user/benefits', [UserController::class, 'benefits'])->name('userBenefits');
Route::post('user/benefits', [UserController::class, 'filterBenefits'])->name('postUserBenefits');

Route::post('user/historic', [UserController::class, 'filterHistoric'])->name('postUserHistoric');
Route::get('user/historic/{kind}', [UserController::class, 'historic'])->middleware(['auth', 'verified'])->name('userHistoric');

Route::get('products/{id}/follow', [ProductController::class, 'follow'])->name('followProduct');
Route::get('products/{id}/archive', [ProductController::class, 'archive'])->name('archiveProduct');
Route::post('products/filter', [ProductController::class, 'filter'])->name('productsSearch');
Route::post('products/bookmark', [ProductController::class, 'bookmark'])->name('productBookmark');
Route::get('products/{id}/picture', [ProductController::class, 'getPicture'])->name('products.getPicture');

Route::get('products/user', [ProductController::class, 'index'])->middleware(['auth', 'verified'])->name('myProducts');
Route::resource('products', ProductController::class)->middleware(['auth', 'verified'])->except(['destroy']);
Route::get('products/{product}/notifications/{notification}', [ProductController::class, 'showFromNotification'])->middleware(['auth', 'verified'])->name('products.showFromNotification');
Route::get('notifications/{id}/delete', [NotificationsController::class, 'delete'])->middleware(['auth', 'verified'])->name('deleteNotif');

Route::get('products/{product}/photos/edit', [ProductPhotoController::class, 'edit'])->name('productPhotos.edit');
Route::put('products/{product}/photos', [ProductPhotoController::class, 'update'])->name('productPhotos.update');

Route::get('products/{product}/website/create', [ProductWebsiteController::class, 'create'])->name('productWebsites.create');
Route::post('products/{product}/website', [ProductWebsiteController::class, 'store'])->name('productWebsites.store');
Route::post('product_website/url/find', [ProductWebsiteController::class, 'findByUrl'])->name('findByUrl');
Route::get('product_website/{product_website}/edit', [ProductWebsiteController::class, 'edit'])->name('productWebsites.edit');
Route::put('product_website/{product_website}', [ProductWebsiteController::class, 'update'])->name('productWebsites.update');

Route::resource('purchases', PurchaseController::class)->except(['index', 'create', 'destroy']);
Route::get('products/{product?}/purchase/create', [PurchaseController::class, 'create'])->name('purchases.create');
Route::get('purchases/{purchase}/destroy', [PurchaseController::class, 'destroy'])->name('purchases.destroy');

Route::resource('group_buys', GroupBuyController::class)->except(['index', 'show', 'destroy']);
Route::get('group_buys/offer/{nb}/product/{productId}/datas', [GroupBuyController::class, 'getProductDatas'])->name('groupBuys.getProductDatas');
Route::get('user/{userId}/group_buys/products/{nb}', [GroupBuyController::class, 'getProducts'])->name('groupBuys.getProducts');
Route::get('group_buys/{group_buy}/destroy', [GroupBuyController::class, 'destroy'])->name('groupBuys.destroy');

Route::resource('sellings', SellingController::class)->except(['index', 'create', 'destroy']);
Route::get('sellings/purchase/{purchase}/create', [SellingController::class, 'create'])->name('sellings.create');
Route::get('sellings/{selling}/destroy', [SellingController::class, 'destroy'])->name('sellings.destroy');

Route::get('lists/users/{userId?}', [ListingController::class, 'getUserLists'])->name('showUserLists');
Route::get('lists/{listId}/products/show', [ListingController::class, 'showProducts'])->name('showListProducts');
Route::post('lists/products/findOthers', [SearchController::class, 'findOtherProducts'])->name('listFindOtherProducts');
Route::post('lists/products/toggle', [ListingController::class, 'toggleProduct'])->name('toggleProductOnList');
Route::resource('lists', ListingController::class)->middleware(['auth', 'verified'])->except(['destroy']);
Route::get('lists/{listId}/destroy', [ListingController::class, 'destroy'])->name('destroyList');
Route::get('lists/{listId}/download', [ListingController::class, 'download'])->name('downloadList');
Route::get('shared/lists/{listId}/show', [ListingController::class, 'showShare'])->name('show_shareList');
Route::post('lists/share', [ListingController::class, 'share'])->name('shareList');
Route::get('lists/{listId}/leave', [ListingController::class, 'leave'])->name('leaveFriendList');
//Listing Messages
Route::post('lists/messages/menu/show', [ListingMessagesController::class, 'getActionsMenu'])->name('openMsgMenu');
Route::post('lists/messages/send', [ListingMessagesController::class, 'send'])->name('sendMessage');
Route::get('lists/messages/{msgId}/delete', [ListingMessagesController::class, 'delete'])->name('listDeleteMessage');
Route::get('lists/messages/{msgId}/{action}', [ListingMessagesController::class, 'pin'])->name('pinMessage');
Route::get('lists/{listId}/delete/messages', [ListingMessagesController::class, 'deleteAll'])->name('listDeleteAllMessages');
Route::get('lists/{listId}/messages/show/{pinned}', [ListingMessagesController::class, 'show'])->name('showMessages');
//Listing Messages Reactions
Route::get('tchat/sections/{sectionId}/show', [EmojiSectionController::class, 'show'])->name('showEmojiSection');
Route::get('lists/messages/{msgId}/emojis/{emojiId}', [ListMsgReactionsController::class, 'toggleReaction'])->name('toggleListMsgReaction');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::post('color/variants', [CssColorController::class, 'get_variants'])->name('getColorVariants');

//Help sidebar
Route::post('benefit', [UtilsController::class, 'simulateBenefit'])->name('simulateBenefit');
Route::post('search/external', [SearchController::class, 'externalSearch'])->name('externalSearch');

Route::get('autocomplete', [SearchController::class, 'autocomplete'])->name('autocomplete');

Route::resource('video_games', VideoGameController::class)->middleware(['auth', 'verified'])->except(['destroy']);
Route::post('video_games/filter', [VideoGameController::class, 'filter'])->name('videoGamesSearch');
Route::get('video_games/{vgId}/vg_support/{vgSupportId?}/products/link', [UtilsController::class, 'linkVgToProduct'])->name('vgLinkProduct');
Route::get('video_games/products/{productId}/unlink', [VideoGameController::class, 'unlinkProduct'])->name('vgUnlinkProduct');

//Admin routes
Route::prefix('admin')->group(function () {
    Route::resource('websites', WebsiteController::class);
    Route::resource('tags', TagController::class);
    Route::resource('emojis', EmojiController::class);
    
    Route::resource('sections/emojis', EmojiSectionController::class)
        ->parameters(['emojis' => 'section'])
        ->except(['show'])
        ->names([
        'index' => 'sections.emojis.index',
        'create' => 'sections.emojis.create',
        'store' => 'sections.emojis.store',
        'edit' => 'sections.emojis.edit',
        'update' => 'sections.emojis.update',
        'destroy' => 'sections.emojis.destroy',
    ]);

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

Route::get('scripts/video_games/product/link', [ScriptsController::class, 'lkAllVgToProduct'])->name('lkAllVgToProduct');

//Simple pages
Route::get('design-system', function() {
    return view("pages.design_system")->render();
})->middleware(['auth', 'verified'])->name('designSystem');

Route::get('design-coding', function() {
    return view("pages.design_coding")->render();
})->middleware(['auth', 'verified'])->name('designCoding');

Route::get('coding-examples', function() {
    return view("pages.coding_examples")->render();
})->middleware(['auth', 'verified'])->name('codingExamples');