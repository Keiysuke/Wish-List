<?php

use App\Http\Controllers\BookPublisherController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CountryController;
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
use App\Http\Controllers\CrowdfundingStateController;
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
use App\Http\Controllers\ShareController;
use App\Http\Controllers\UtilsController;
use App\Http\Controllers\VgSupportController;
use App\Http\Controllers\VgDeveloperController;
use App\Http\Controllers\VideoGameController;
use App\Models\BookPublisher;
use App\Http\Controllers\CrowdfundingController;
use App\Models\CrowdfundingState;
use App\Http\Controllers\TravelJourneyController;

Route::get('/', function () {return view('welcome');})->name('home');
Route::get('/sitemap', function () {return view('sitemap');})->name('sitemap');
Route::get('/render_icon/{kind}', [EmojiController::class, 'renderIcon'])->name('renderIcon');

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
Route::post('lists/{listId}/products/show', [ListingController::class, 'showProducts'])->name('showListProducts');
Route::post('lists/products/findOthers', [SearchController::class, 'findOtherProducts'])->name('listFindOtherProducts');
Route::post('lists/products/toggle', [ListingController::class, 'toggleProduct'])->name('toggleProductOnList');
Route::resource('lists', ListingController::class)->middleware(['auth', 'verified'])->except(['destroy']);
Route::get('lists/{listId}/destroy', [ListingController::class, 'destroy'])->name('destroyList');
Route::get('lists/{listId}/download', [ListingController::class, 'download'])->name('downloadList');
Route::get('shared/lists/{listId}/products/{productId}/edit', [ListingController::class, 'showEditProduct'])->name('show_editProduct');
Route::get('user/friends/share/{type}/{id}', [ShareController::class, 'showList'])->name('show_shareList');
Route::post('share', [ShareController::class, 'share'])->name('share');
Route::get('lists/{listId}/leave', [ListingController::class, 'leave'])->name('leaveFriendList');
//Listing Messages
Route::post('lists/messages/menu/show', [ListingMessagesController::class, 'getActionsMenu'])->name('openMsgMenu');
Route::get('lists/{listId}/messages/get', [ListingMessagesController::class, 'getMessages'])->name('getMessages');
Route::post('lists/messages/send', [ListingMessagesController::class, 'send'])->name('sendMessage');
Route::get('lists/messages/{msgId}/edit', [ListingMessagesController::class, 'edit'])->name('listEditMessage');
Route::post('lists/messages/{msgId}/update', [ListingMessagesController::class, 'update'])->name('listUpdateMessage');
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

    $resources = [
        'sections/emojis' => [
            'controller' => EmojiSectionController::class,
            'param' => ['emojis' => 'section'],
            'name' => 'sections.emojis'
        ],
        'states/products' => [
            'controller' => ProductStateController::class,
            'param' => ['products' => 'product_state'],
            'name' => 'states.products'
        ],
        'states/sells' => [
            'controller' => SellStateController::class,
            'param' => ['sells' => 'sell_state'],
            'name' => 'states.sells'
        ],
        'states/crowdfundings' => [
            'controller' => CrowdfundingStateController::class,
            'param' => ['crowdfundings' => 'crowdfunding_state'],
            'name' => 'states.crowdfundings'
        ],
        'video_games/supports' => [
            'controller' => VgSupportController::class,
            'param' => ['supports' => 'vg_support'],
            'name' => 'vg_supports'
        ],
        'video_games/developers' => [
            'controller' => VgDeveloperController::class,
            'param' => ['developers' => 'vg_developer'],
            'name' => 'vg_developers'
        ],
        'books/publishers' => [
            'controller' => BookPublisherController::class,
            'param' => ['publishers' => 'publisher'],
            'name' => 'book_publishers'
        ],
        'cities' => [
            'controller' => CityController::class,
            'param' => ['cities' => 'city'],
            'name' => 'cities'
        ],
        'countries' => [
            'controller' => CountryController::class,
            'param' => ['countries' => 'country'],
            'name' => 'countries'
        ],
    ];

    foreach ($resources as $uri => $options) {
        Route::resource($uri, $options['controller'])
            ->parameters($options['param'])
            ->except(['show'])
            ->names([
                'index' => "{$options['name']}.index",
                'create' => "{$options['name']}.create",
                'store' => "{$options['name']}.store",
                'edit' => "{$options['name']}.edit",
                'update' => "{$options['name']}.update",
                'destroy' => "{$options['name']}.destroy",
            ]);
    }
});

Route::get('scripts/video_games/product/link', [ScriptsController::class, 'lkAllVgToProduct'])->name('lkAllVgToProduct');
Route::get('scripts/product/publishers/link', [ScriptsController::class, 'lkProductsToPublishers'])->name('lkProductsToPublishers');

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

Route::get('coding-services', function() {
    return view("pages.coding_services")->render();
})->middleware(['auth', 'verified'])->name('codingServices');

Route::resource('crowdfundings', CrowdfundingController::class)->except(['index', 'show', 'destroy']);
Route::get('products/{product}/crowdfundings/create', [CrowdfundingController::class, 'createForProduct'])->name('products.crowdfundings.create');

Route::resource('travel_journeys', TravelJourneyController::class)->middleware(['auth', 'verified']);
Route::get('user/{userId}/travel_journeys/steps/{nb}', [TravelJourneyController::class, 'getSteps'])->name('travelJourneys.getSteps');
Route::get('user/{userId}/travel_journeys/steps/{stepNb}/products/{nb}', [TravelJourneyController::class, 'getStepProducts'])->name('travelJourneys.getStepProducts');