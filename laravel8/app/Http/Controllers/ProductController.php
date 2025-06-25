<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Listing;
use App\Models\ListingProduct;
use App\Models\ProductTag;
use Illuminate\Notifications\DatabaseNotification;
use Carbon\Carbon;
use App\Http\Controllers\ProductTemplateController;
use App\Http\Requests\ProductFilterRequest;
use App\Services\CrowdfundingService;
use App\Services\DateService;
use App\Services\Filters\ProductFilterService;
use App\Services\ProductService;
use App\Services\ProductWebsiteService;
use App\Services\PurchaseService;
use App\Services\UploadService;

class ProductController extends Controller
{
    private $nb_page_results = 15;

    public function getPicture(int $id){
        $product = Product::find($id);
        $product->setFirstPhoto();
        return response()->json(['success' => true, 'html' => $product->pict, 'link' => route('products.show', $id)]);
    }

    //Routes
    public function index(Request $request){
        //Si la mise à jour des notifications n'a pas été faite
        app('App\Http\Controllers\NotificationsController')->checkProductNotifications();
        app('App\Http\Controllers\NotificationsController')->checkVideoGameNotifications();
        app('App\\Http\\Controllers\\NotificationsController')->checkCrowdfundingNotifications();

        $sortBy = (object)['kind' => 'date', 'order' => 'desc', 'list' => 'grid', 'show_archived' => 0];
        $filters = (object)[
            'purchased' => 'purchased_all', 
            'stock' => request('stock', 'product_all'), 
            'tag_in' => request('tag_in', 0), 
            'crowdfunding' => request('crowdfunding', 0), 
            'f_nb_results' => $this->nb_page_results
        ];
        $search = $request->search;

        $buildRequest = Product::query();
        if($request->path() === 'products/user'){
            $buildRequest->whereHas('users', function($query){
                $query->where('user_id', '=', auth()->user()->id);
            });
        }else{
            $buildRequest->whereHas('users', function($query){
                $query->where('user_id', '<>', auth()->user()->id);
            });
        }

        if(!is_null($search)) $buildRequest->where('label', 'like', '%'.$search.'%');
        $buildRequest->where('archived', '=', $sortBy->show_archived);
        $products = $buildRequest->orderBy('created_at', $sortBy->order)->paginate($this->nb_page_results);

        if ($request->query('fast_search') && count($products) === 1) {
            return redirect()->route('products.show', $products->first()->id);
        }
        
        $paginator = (object)['cur_page' => $products->links()->paginator->currentPage()];
        $products->useAjax = true; //Permet l'utilisation du système de pagination en ajax
        
        (new ProductService())->setProductWebsites($products);
        return view('products.index', compact('products', 'sortBy', 'filters', 'search', 'paginator'));
    }

    function filter(ProductFilterRequest $request){
        abort_unless($request->ajax(), 404);
        $products = (new ProductFilterService())->applyFilters($request);
        $products->useAjax = true; //Permet l'utilisation du système de pagination en ajax
                    
        $html = view('partials.products.'.$request->list.'_details', [
            'products' => $this->getProducts($products)
        ])->render();
        return response()->json(['success' => true, 'nb_results' => $products->links()? $products->links()->paginator->total() : count($products), 'html' => $html]);
    }

    function getProducts($products){
        $productService = new ProductService();
        $productService->setProductWebsites($products);
        $productService->setProductPurchases($products);
        return $products;
    }

    function follow(int $id){
        $user = User::find(auth()->user()->id);
        $user->products()->toggle($id);
        return response()->json([
            'success' => true, 
            'product' => ['follow' => $user->products()->find($id)],
        ]);
    }

    function archive(int $id){
        $product = Product::find($id);
        $product->archived = !$product->archived;
        $product->save();
        return response()->json([
            'success' => true, 
            'product' => ['archived' => $product->archived],
        ]);
    }

    public function create(){
        return view('products.create', ['today' => DateService::today()]);
    }

    public function store(ProductRequest $request){
        $product = (new ProductService())->createFromRequest($request);
        
        if (UtilsController::checkKeyExistingInArray($request->all(), 'photo_')) {//Adding the photo
            UploadService::storePhoto($request, 1, $product);
        }
        $info = __('The product has been created.');
        //Adding the potential tags
        $tagIds = $request->tag_ids ?? [];
        $this->updateTags($tagIds, $product->tag_ids(), $product->id);
        
        //We link it to the current user
        $product->users()->attach($request->user_id);

        //Set product's kind if inputed
        ProductTemplateController::updateProduct($request, $product);
        
        if($request->add_offer) //On lie une offre avec le site web utilisé
            (new ProductWebsiteService())->createFromRequest($request, $product);

        if($request->add_purchase) //On lie un nouvel achat
            (new PurchaseService())->createFromRequest($request);

        if($request->add_crowdfunding) { //On lie un nouvel achat
            (new CrowdfundingService())->createFromRequest($request);
        }

        if($request->add_vg) { //On lie un nouveau JV
            // (new VideoGameService())->createFromRequest($request->merge([
            //     'label' => ProductService::getLabelAsVideoGame($product),
            // ]));
        }
        
        $info = __('The product & associated data have been created.');
        return redirect()->route('products.show', $product->id)->with('info', $info);
    }
    
    public function show(Product $product){
        $product->createdBy();
        $product->following();
        $product->setFirstPhoto();
        $productWebsites = $product->productWebsites()->orderBy('price')->get();
        $purchases = $product->purchases()->orderBy('date')->get();
        $photos = $product->photos()->orderBy('ordered')->get();
        $productWebsites->nb_expired = 0;
        //On ajoute des infos pour l'affichage
        foreach($purchases as $purchase){
            if(!is_null($purchase->selling) && $purchase->selling->isSold()){
                $purchase->display_type = 'benef';
            }elseif(!is_null($purchase->selling)){
                $purchase->display_type = 'sell';
            }else{
                $purchase->display_type = 'buy';
            }
        }
        
        foreach($productWebsites as $pw){
            $pw->expired = !is_null($pw->expiration_date) && ($pw->expiration_date < Carbon::now());
            $pw->available_soon = !is_null($pw->available_date) && ($pw->available_date >= Carbon::now());
            $pw->lower_price = $pw->price < $product->real_cost;
            
            if(($pw->expired || !is_null($pw->expiration_date)) && !$pw->available_soon){ //Une date d'expiration est renseignée
                $pw->date_show = __('Expire');
                $pastDate = $pw->expiration_date < Carbon::now();
                if($pastDate){
                    $productWebsites->nb_expired++;
                    $pw->date_show = __('Expired');
                }
                $pw->date_show .= ' '.ProductWebsiteService::showAvailableDate($pw->expiration_date, $pastDate);
            }elseif($pw->available_soon){
                $pw->date_show = __('Available').' '.ProductWebsiteService::showAvailableDate($pw->available_date);
            }
        }
        
        $lists = Listing::where('user_id', '=', auth()->user()->id)->get();
        foreach($lists as $list){
            $list->hasProduct = $list->products()->find($product->id);
            $list->product_nb = ($list->hasProduct)? ListingProduct::where('product_id', '=', $product->id)->first()->nb : 1;
        }
        return view('products.show', compact('product', 'photos', 'productWebsites', 'purchases', 'lists'));
    }
    
    public function showFromNotification(Product $product, DatabaseNotification $notification){
        $notification->markAsRead();
        return $this->show($product);
    }

    public function edit(Product $product){
        $product->setFirstPhoto();
        $websites = \App\Models\Website::all();
        return view('products.edit', compact('product', 'websites'));
    }
    
    public function update(ProductRequest $request, Product $product){
        if($request->add_purchase){
            $request->merge([
                'price' => str_replace(',', '.', $request->price),
                'cost' => str_replace(',', '.', $request->cost)
            ]);
        }
        $tagIds = $request->tag_ids ?? [];
        $this->updateTags($tagIds, $product->tag_ids(), $product->id);
        
        $request->merge(['real_cost' => str_replace(',', '.', $request->real_cost)]);
        $product->update($request->all());
        
        //Set product's kind if inputed
        ProductTemplateController::updateProduct($request, $product);

        return redirect()->route('products.show', $product->id)->with('info', __('The product has been edited.'));
    }

    public function updateTags(Array $newTags, Array $oldTags, int $productId): void{
        foreach($oldTags as $oldId){ //Delete old and no more selected tags
            if(!in_array($oldId, $newTags)) ProductTag::where('product_id', '=', $productId)->where('tag_id', '=', $oldId)->delete();
        }
        foreach($newTags as $newId){ //Adding new tags not previously selected
            if(!in_array($newId, $oldTags)){
                (new ProductTag(['product_id' => $productId, 'tag_id' => $newId]))->save();
            }
        }
    }
}

