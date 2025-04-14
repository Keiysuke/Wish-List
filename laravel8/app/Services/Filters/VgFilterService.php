<?php

namespace App\Services\Filters;

use App\Http\Requests\VgFilterRequest;
use App\Models\VgSupport;
use App\Models\VideoGame;
use Illuminate\Database\Eloquent\Builder;

class VgFilterService
{
    public function applyFilters(VgFilterRequest $request)
    {
        switch($request->sort_by){
            case 'alpha': $sortBy = 'label';
                break;
            case 'players': $sortBy = 'nb_players';
                break;
            case 'date_released': $sortBy = 'date_released';
                break;
            default: $sortBy = 'created_at';
        }
        $buildRequest = VideoGame::query();

        // if($request->url === 'video_games/user'){
        //     $buildRequest->whereHas('users', function($query){
        //         $query->where('user_id', '=', auth()->user()->id);
        //     });
        // }else{
        //     $buildRequest->whereHas('users', function($query){
        //         $query->whereNotIn('product_id', function($query){
        //             $query->select('product_id')->from('product_users')->where('user_id', '=', auth()->user()->id);
        //         });
        //     })->orWheredoesntHave('users');
        // }
        
        //Filtrés par produits achetés ou non, vendus ou non
        $this->applyProductBoughtFilter($buildRequest, $request);
        //Filter on vg_supports
        $this->applyVgSupportFilter($buildRequest, $request);
        
        $buildRequest->where('label', 'like', '%'.$request->search_text.'%');
        return $buildRequest->orderBy($sortBy, $request->order_by)->paginate($request->f_nb_results);
    }

    function applyProductBoughtFilter(Builder &$buildRequest, VgFilterRequest $request){
        switch($request->purchased){
            case 'purchased_yes': $buildRequest->whereHas('products', function($query){
                    $query->whereHas('product', function($query){
                        $query->whereHas('purchases', function($query){
                            $query->doesntHave('selling');
                        });
                    });
                });
                break;
            case 'purchased_no': $buildRequest->whereHas('products', function($query){
                $query->whereHas('product', function($query){
                        $query->doesntHave('purchases');
                    });
                });
                break;
            case 'resold': $buildRequest->whereHas('products', function($query){
                $query->whereHas('product', function($query){
                        $query->whereHas('sellings', function($query){
                            $query->whereNotNull('date_send');
                        });
                    });
                });
                break;
            default: $buildRequest->where('label', 'like', '%'.$request->search_text.'%');
        }
    }

    function applyVgSupportFilter(Builder &$buildRequest, VgFilterRequest $request){
        $filterSupport = [];
        //Filtrés par support JV
        foreach($request->vg_supports as $support){
            $r = explode('vg_support_', $support);
            $filterSupport[] = intval($r[1]);
        }

        if(!count($filterSupport)){
            $buildRequest->wheredoesntHave('vg_supports');
            
        }elseif(strcmp(count($filterSupport), VgSupport::count())){
            $buildRequest->whereHas('vg_supports', function($query) use ($filterSupport){
                $query->whereIn('vg_support_id', $filterSupport);
            });
        }
    }
}