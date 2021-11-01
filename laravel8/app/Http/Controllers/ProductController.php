<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Website;
use App\Models\ProductPhoto;
use App\Models\ProductWebsite;
use App\Models\Purchase;
use App\Models\Listing;
use App\Models\ListingProduct;
use Illuminate\Notifications\DatabaseNotification;
use Carbon\Carbon;
use EloquentBuilder;

class ProductController extends Controller
{
    private $nb_page_results = 15;

    public function get_picture(Request $request){
        if ($request->ajax()) {
            $this->validate($request, ['product_id' => 'bail|required|int']);
            $product_id = $request->product_id;

            $photo = ProductPhoto::where('product_id', '=', $product_id)->first();
            $returnHTML = asset(config('images.path_products').'/'.$product_id.'/'.$photo->label);
            return response()->json(['success' => true, 'html' => $returnHTML]);
        }
    }

    public function setProductWebsites(&$products){
        foreach($products as $product){
            $product->nb_offers = count($product->getAvailableWebsites());
            $product->can_buy = $product->nb_offers > count($product->getWebsitesAvailableSoon());
            $product->date_show = null;

            if($product->nb_offers > 0){ //Des offres sont disponibles
                if($product->can_buy){
                    if(count($product->purchases) >= 1){
                        $product->date_show = __('Purchased on').' '.date('d/m/Y', strtotime($product->purchases()->orderBy('date')->first()->date));
                    }else{
                        //On affiche la date d'expiration la plus proche
                        $nextExpiration = $product->getwebsitesExpirationSoon()->first();
                        if(is_null($nextExpiration)) $product->date_show = __('Not bought');
                        else $product->date_show = __('An offer expire on').' '.app('App\Http\Controllers\ProductWebsiteController')->showAvailableDate($nextExpiration->expiration_date);
                    }
                }else{ //Les offres sont pour des dates futures
                    $offer = $product->getWebsitesAvailableSoon()->first();
                    $product->date_show = app('App\Http\Controllers\ProductWebsiteController')->showAvailableDate($offer->available_date);
                }
            }else $product->date_show = __('No offer listed');
        }
    }

    public function setProductPurchases(&$products){
        foreach($products as $product){
            $product->url = route('products.show', $product->id);
            $product->pict = asset(config('images.path_products').'/'.$product->id.'/'.$product->photos()->firstWhere('ordered', 1)->label);
            $product->description = strlen($product->description) > 450 ? substr($product->description, 0, 450).'...': $product->description;
            $product->nb_purchases = count($product->purchases);
            $product->nb_resells = 0;
            foreach($product->sellings as $selling){
                if($selling->resold()) $product->nb_resells++;
            }
            $product->nb_sellings = count($product->sellings)-$product->nb_resells;
        }
    }

    //Routes
    public function index(Request $request){
        //Si la mise à jour des notifications n'a pas été faite
        app('App\Http\Controllers\NotificationsController')->checkProductNotifications();

        $sortBy = (object)['kind' => 'date', 'order' => 'desc', 'list' => 'grid'];
        $filters = (object)['purchased' => 'purchased_all', 'stock' => request('stock', 'product_all'), 'f_nb_results' => $this->nb_page_results];
        $search = $request->search;

        $buildRequest = Product::query();
        if($request->path() === 'products/user'){
            $buildRequest->whereHas('users', function($query){
                $query->where('user_id', '=', \Auth::user()->id);
            });
        }else{
            $buildRequest->whereHas('users', function($query){
                $query->where('user_id', '<>', \Auth::user()->id);
            });
        }

        if(!is_null($search)) $buildRequest->where('label', 'like', '%'.$search.'%');
        $products = $buildRequest->orderBy('created_at', $sortBy->order)->paginate($this->nb_page_results);
        // dd($products);
        // \DB::enableQueryLog();
        // dd(\DB::getQueryLog());
        // die();
        
        $paginator = (object)['cur_page' => $products->links()->paginator->currentPage()];
        $products->use_ajax = true; //Permet l'utilsation du système de pagination en ajax
        
        $this->setProductWebsites($products);
        return view('products.index', compact('products', 'sortBy', 'filters', 'search', 'paginator'));
    }

    function filter(Request $request){
        if ($request->ajax()) {
            $this->validate($request, [
                'search_text' => 'bail|nullable|string',
                'sort_by' => 'bail|required|string',
                'order_by' => 'bail|required|string',
                'list' => 'bail|required|string',
                'page' => 'bail|required|int',
                'stock' => 'bail|required|string',
                'purchased' => 'bail|required|string',
                'f_nb_results' => 'bail|required|int',
            ]);
            switch($request->sort_by){
                case 'alpha': $sort_by = 'label';
                break;
                case 'price': $sort_by = 'real_cost';
                break;
                default: $sort_by = 'created_at';
            }

            $buildRequest = Product::query();
            $filter_pw = [];
            //Filtrés par sites
            foreach($request->websites as $product_website){
                $r = explode('_', $product_website);
                $filter_pw[] = intval($r[1]);
            }

            if($request->url === 'products/user'){
                $buildRequest->whereHas('users', function($query){
                    $query->where('user_id', '=', \Auth::user()->id);
                });
            }else{
                $buildRequest->whereHas('users', function($query){
                    $query->whereNotIn('product_id', function($query){
                        $query->select('product_id')->from('product_users')->where('user_id', '=', \Auth::user()->id);
                    });
                })->orWheredoesntHave('users');
            }

            //$products = DB::table('product_websites')->rightJoin('products', 'product_websites.product_id', '=', 'products.id')->get();
            if($request->stock === 'product_missing'){
                $buildRequest->wheredoesntHave('productWebsites')
                    ->orWhereHas('productWebsites', function($query){
                        $query->where([['expiration_date', '<>', null], ['expiration_date', '<=', date("Y-m-d H:i:s")], ['available_date', '=', null]]);
                });
            }elseif($request->stock === 'product_all' and $request->purchased === 'purchased_all' and !strcmp(count($filter_pw), Website::count())){
                $buildRequest->where(function($query) use ($filter_pw){
                    $query->wheredoesntHave('productWebsites')
                    ->orWhereHas('productWebsites', function($query) use ($filter_pw){
                        $query->whereIn('website_id', $filter_pw);
                    });
                });
            }else{
                $buildRequest->whereHas('productWebsites', function($query) use ($filter_pw){
                    $query->whereIn('website_id', $filter_pw);
                });
            }

            //Filtrés par produits achetés ou non, vendus ou non
            switch($request->purchased){
                case 'purchased_yes': $buildRequest->whereHas('purchases', function($query){
                    $query->doesntHave('selling');
                });
                    break;
                case 'purchased_no': $buildRequest->doesntHave('purchases');
                    break;
                case 'selling': $buildRequest->whereHas('sellings', function($query){
                        $query->whereNull('date_send');
                    });
                    break;
                case 'resold': $buildRequest->whereHas('sellings', function($query){
                        $query->whereNotNull('date_send');
                    });
                    break;
                case 'discount': $buildRequest->whereHas('purchases', function($query){
                        $query->where('discount', '>', '0');
                    });
                    break;
                case 'free': $buildRequest->whereHas('purchases', function($query){
                        $query->whereRaw('cost - discount <= 1');
                    });
                    break;
                default: $buildRequest->where('label', 'like', '%'.$request->search_text.'%');
            }

            //Filtrés par produits disponibles, a venir, expirés
            switch($request->stock){
                case 'product_available': 
                    $buildRequest->whereHas('productWebsites', function($query){
                        $query->where([['available_date', '<=', date("Y-m-d H:i:s")], ['expiration_date', '>', date("Y-m-d")]])
                            ->orWhere([['available_date', '<=', date("Y-m-d H:i:s")], ['expiration_date', '=', null]])
                            ->orWhere([['available_date', '=', null], ['expiration_date', '>', date("Y-m-d")]])
                            ->orWhere([['available_date', '=', null], ['expiration_date', '=', null]]);
                    })->where('label', 'like', '%'.$request->search_text.'%');
                    break;
                case 'product_to_come': 
                    $buildRequest->whereHas('productWebsites', function($query){
                        $query->where([['available_date', '>', date("Y-m-d H:i:s")], ['available_date', '<>', null]]);
                    })->where('label', 'like', '%'.$request->search_text.'%');
                    break;
                case 'product_expired': 
                    $buildRequest->whereHas('productWebsites', function($query){
                        $query->where([['expiration_date', '<>', null], ['expiration_date', '<=', date("Y-m-d H:i:s")], ['available_date', '=', null]]);
                    })->where('label', 'like', '%'.$request->search_text.'%');
                    break;
                default: $buildRequest->where('label', 'like', '%'.$request->search_text.'%');
            }
            $products = $buildRequest->orderBy($sort_by, $request->order_by)->paginate($request->f_nb_results);
            $products->use_ajax = true; //Permet l'utilsation du système de pagination en ajax
                        
            $returnHTML = view('partials.products.'.$request->list.'_details')->with(['products' => $this->get_products($products)])->render();
            return response()->json(['success' => true, 'nb_results' => $products->links()? $products->links()->paginator->total() : count($products), 'html' => $returnHTML]);
        }
        abort(404);
    }

    function get_products($products){
        $this->setProductWebsites($products);
        $this->setProductPurchases($products);
        return $products;
    }

    function follow(Request $request){
        if ($request->ajax()) {
            $this->validate($request, ['id' => 'bail|required|int']);
            
            User::find(auth()->user()->id)->products()->toggle($request->id);
            return response()->json(['success' => true, 'product' => ['follow' => $user->products()->find($request->id)]]);
        }
    }

    public function create(){
        return view('products.create');
    }

    public function store(ProductRequest $request){
        $product = new Product([
            'label' => $request->label,
            'description' => $request->description,
            'limited_edition' => $request->limited_edition,
            'real_cost' => str_replace(',', '.', $request->real_cost),
        ]);
        $product->save();
        //Adding the photo
        app('App\Http\Controllers\UploadController')->storePhoto($request, 1, $product);
        $info = __('The product has been created.');

        //We link it to the current user
        $product->users()->attach($request->user_id);
        
        if($request->add_purchase){ //On créé et lie également un achat et le site web utilisé

            $product_website = new ProductWebsite([
                'product_id' => $product->id,
                'website_id' => $request->website_id,
                'price' => str_replace(',', '.', $request->price),
                'url' => $request->url,
                'expiration_date' => $request->expiration_date,
            ]);
            $product_website->save();
            
            $purchase = new Purchase([
                'user_id' => $request->user_id,
                'product_id' => $product->id,
                'product_state_id' => $request->product_state_id,
                'website_id' => $request->website_id,
                'cost' => str_replace(',', '.', $request->cost),
                'date' => $request->date,
            ]);
            $purchase->save();
            
            $info = __('The product & the related purchase have been created.');
        }

        return redirect()->route('products.show', $product->id)->with('info', $info);
    }
    
    public function show(Product $product){
        $product->createdBy();
        $product->following();
        $product_websites = $product->productWebsites()->orderBy('price')->get();
        $purchases = $product->purchases()->orderBy('date')->get();
        $photos = $product->photos()->orderBy('ordered')->get();
        $product_websites->nb_expired = 0;
        //On ajoute des infos pour l'affichage
        foreach($purchases as $purchase){
            if(!is_null($purchase->selling) && $purchase->selling->resold()){
                $purchase->display_type = 'benef';
            }elseif(!is_null($purchase->selling)){
                $purchase->display_type = 'sell';
            }else{
                $purchase->display_type = 'buy';
            }
        }

        foreach($product_websites as $pw){
            $pw->expired = !is_null($pw->expiration_date) && ($pw->expiration_date < Carbon::now());
            $pw->available_soon = !is_null($pw->available_date) && ($pw->available_date >= Carbon::now());
            $pw->lower_price = $pw->price < $product->real_cost;
            
            if(($pw->expired || !is_null($pw->expiration_date)) && !$pw->available_soon){ //Une date d'expiration est renseignée
                $pw->date_show = __('Expire');
                $past_date = $pw->expiration_date < Carbon::now();
                if($past_date){
                    $product_websites->nb_expired++;
                    $pw->date_show = __('Expired');
                }
                $pw->date_show .= ' '.app('App\Http\Controllers\ProductWebsiteController')->showAvailableDate($pw->expiration_date, $past_date);
            }elseif($pw->available_soon){
                $pw->date_show = __('Available').' '.app('App\Http\Controllers\ProductWebsiteController')->showAvailableDate($pw->available_date);
            }
        }

        $lists = Listing::where('user_id', '=', auth()->user()->id)->get();
        foreach($lists as $list){
            $list->hasProduct = $list->products()->find($product->id);
            $list->product_nb = ($list->hasProduct)? ListingProduct::where('product_id', '=', $product->id)->first()->nb : 1;
        }
        return view('products.show', compact('product', 'photos', 'product_websites', 'purchases', 'lists'));
    }

    public function showFromNotification(Product $product, DatabaseNotification $notification){
        $notification->markAsRead();
        return $this->show($product);
    }

    public function edit(Product $product){
        return view('products.edit', compact('product'));
    }
    
    public function update(ProductRequest $request, Product $product){
        if($request->add_purchase){
            $request->merge(['price' => str_replace(',', '.', $request->price),
                'cost' => str_replace(',', '.', $request->cost)
            ]);
        }
        $request->merge(['real_cost' => str_replace(',', '.', $request->real_cost)]);
        $product->update($request->all());
        return redirect()->route('products.show', $product->id)->with('info', __('The product has been edited.'));
    }
}
