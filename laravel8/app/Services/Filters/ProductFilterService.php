<?php

namespace App\Services\Filters;

use App\Http\Requests\ProductFilterRequest;
use App\Models\Product;
use App\Models\Tag;
use App\Models\Website;
use Illuminate\Database\Eloquent\Builder;

class ProductFilterService
{
    public function applyFilters(ProductFilterRequest $request)
    {
        switch($request->sort_by){
            case 'alpha': $sort_by = 'label';
                break;
            case 'price': $sort_by = 'real_cost';
                break;
            default: $sort_by = 'created_at';
        }

        $buildRequest = Product::query();
        $this->applyTagsFilter($buildRequest, $request); //Contient applyWebsiteFilter
        //Filtrés par produits achetés ou non, vendus ou non
        $this->applyBoughtFilter($buildRequest, $request);
        //Filtrés par produits disponibles, a venir, expirés
        $this->applyStockFilter($buildRequest, $request);
        
        return $buildRequest->orderBy($sort_by, $request->order_by)->paginate($request->f_nb_results);
    }

    function applyTagsFilter(Builder &$buildRequest, ProductFilterRequest $request){
        $filterTag = ['in' => [], 'out' => []];
        $tags = Tag::all();
        //Filtrés par tags
        foreach($tags as $tag){
            if(in_array('tag_'.$tag->id, $request->tags)) $filterTag['in'][] = $tag->id;
            else $filterTag['out'][] = $tag->id;
        }
        //Ajout des tags filtrés
        if (!is_null($request->tag_in) && !in_array($request->tag_in, $filterTag['in'])) {
            $filterTag['in'][] = $request->tag_in;
        }
        if (!is_null($request->tag_out) && !in_array($request->tag_out, $filterTag['out'])) {
            $filterTag['out'][] = $request->tag_out;
        }
        
        if($request->url === 'products/user'){
            $buildRequest->whereHas('users', function($query) use ($request){
                $query->where('user_id', '=', auth()->user()->id)
                    ->where('archive', '=', $request->show_archived);
            });
        }else{
            $buildRequest->whereHas('users', function($query) use ($request){
                $query->whereNotIn('product_id', function($query){
                    $query->select('product_id')->from('product_users')->where('user_id', '=', auth()->user()->id);
                })
                ->where('archive', '=', $request->show_archived);
            })->orWheredoesntHave('users');
        }
        
        //$products = DB::table('productWebsites')->rightJoin('products', 'productWebsites.product_id', '=', 'products.id')->get();
        $this->applyWebsiteFilter($buildRequest, $request);

        //Filter on tags
        if($request->no_tag){
            $buildRequest->wheredoesntHave('tags');
            
        }elseif(count($filterTag['in']) > 0){
            $buildRequest->whereHas('tags', function($query) use ($filterTag){
                $query->whereIn('tag_id', $filterTag['in']);
            });
            if($request->exclusive_tags){
                $buildRequest->whereDoesntHave('tags', function($query) use ($filterTag){
                    $query->whereIn('tag_id', $filterTag['out']);
                });
            }
        }
    }

    function applyWebsiteFilter(Builder &$buildRequest, ProductFilterRequest $request){
        $filterPw = [];
        //Filtrés par sites
        if($request->crowdfunding){
            $filterPw = Website::getCrowdfundingWebsites();
        }else{
            foreach($request->websites as $product_website){
                $r = explode('_', $product_website);
                $filterPw[] = intval($r[1]);
            }
        }

        if($request->stock === 'product_missing'){
            $buildRequest->wheredoesntHave('productWebsites')
            ->orWhereHas('productWebsites', function($query){
                $query->where([['expiration_date', '<>', null], ['expiration_date', '<=', date("Y-m-d H:i:s")], ['available_date', '=', null]]);
            });
        }elseif($request->stock === 'product_all' and $request->purchased === 'purchased_all' and !strcmp(count($filterPw), Website::count())){
            $buildRequest->where(function($query) use ($filterPw){
                $query->wheredoesntHave('productWebsites')
                ->orWhereHas('productWebsites', function($query) use ($filterPw){
                    $query->whereIn('website_id', $filterPw);
                });
            });
        }else{
            $buildRequest->whereHas('productWebsites', function($query) use ($filterPw){
                $query->whereIn('website_id', $filterPw);
            });
        }
    }

    function applyBoughtFilter(Builder &$buildRequest, ProductFilterRequest $request){
        switch($request->purchased){
            case 'purchased_yes': $buildRequest->whereHas('purchases', function($query){
                    $query->doesntHave('selling');
                });
                break;
            case 'purchased_no': $buildRequest->doesntHave('purchases');
                break;
            case 'not_received': $buildRequest->whereHas('purchases', function($query){
                    $query->whereNull('date_received');
                });
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
    }

    function applyStockFilter(Builder &$buildRequest, ProductFilterRequest $request){
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
    }
}