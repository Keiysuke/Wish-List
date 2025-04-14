<?php

namespace App\Services\Filters;

use App\Http\Requests\UserBenefitsRequest;
use App\Models\Purchase;
use App\Models\SellState;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Builder;

class UserBenefitsFilterService
{
    public function applyFilters(UserBenefitsRequest $request, &$nb_results)
    {
        $date_from = is_null($request->date_from)? '1970-01-01' : $request->date_from;
        $date_to = is_null($request->date_to)? '3000-01-01' : $request->date_to;
        $userId = $request->user_id;
        $nb_results = $request->nb_results === 'all' ? -1 : $request->nb_results;

        /* Creating the query */
        $buildRequest = Purchase::query();
        $buildRequest->where('user_id', '=', $userId)
            ->where('date', '>=', $date_from)
            ->where('date', '<=', $date_to);
            
        $this->applyTagsFilter($buildRequest, $request);
        //Filtrés par produits achetés ou vendus
        $this->applyBoughtFilter($buildRequest, $request);
        //Filtrés par sites
        $this->applyWebsiteFilter($buildRequest, $request);
        
        return $buildRequest->orderBy('date', 'desc')->limit($nb_results)->get();
    }

    function formatResults(Array &$totals, Object &$datas){
        foreach($datas as $data){
            $data->kind = 'purchase';
            $data->cost = $data->cost - $data->discount;
            //Selling datas
            $sell = (isset($data->selling) && $data->selling->isSold()) ? $data->selling : null;
            $data->sold_price = is_null($sell) ? '-' : $sell->confirmed_price;
            $data->shipping_fees = is_null($sell) ? '-' : $sell->shipping_fees;
            $data->shipping_fees_payed = is_null($sell) ? '-' : $sell->shipping_fees_payed;
            $data->benefits = is_null($sell) ? '-' : $data->getBenefits();

            $totals['paid'] += $data->cost;
            //Adding to the Total if it has been sold
            if (!is_null($sell)) {
                $totals['sold'] += ($data->sold_price + $data->fees) - $data->fees_payed;
                $totals['benefits'] += $data->benefits;
            }
        }
    }

    function applyTagsFilter(Builder &$buildRequest, UserBenefitsRequest $request){
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

        //Filter on tags
        if($request->no_tag){
            $buildRequest->whereHas('product', function($query) {
                $query->wheredoesntHave('tags');
            });
            
        }elseif(count($filterTag['in']) > 0){
            $buildRequest->whereHas('product', function($query) use ($filterTag){
                $query->whereHas('tags', function($q) use ($filterTag) {
                    $q->whereIn('tag_id', $filterTag['in']);
                });
            });
            if($request->exclusive_tags){
                $buildRequest->whereDoesntHave('product', function($query) use ($filterTag){
                    $query->whereHas('tags', function($q) use ($filterTag) {
                        $q->whereIn('tag_id', $filterTag['out']);
                    });
                });
            }
        }
    }

    function applyBoughtFilter(Builder &$buildRequest, UserBenefitsRequest $request){
        switch($request->purchased){
            case 'purchased_all': break;
            case 'purchased_yes': $buildRequest->doesntHave('selling');
                break;
            case 'selling': $buildRequest->whereHas('selling', function($query){
                    $query->whereNull('date_send');
                });
                break;
            default: $buildRequest->whereHas('selling', function($query) {
                    $query->where('sell_state_id', '=', SellState::CLOSED);
                });
        }
    }

    function applyWebsiteFilter(Builder &$buildRequest, UserBenefitsRequest $request){
        $filterPw = [];
        //Filtrés par sites
        foreach($request->websites as $product_website){
            $r = explode('_', $product_website);
            $filterPw[] = intval($r[1]);
        }

        //Filter on Websites
        $buildRequest->whereHas('website', function($query) use ($filterPw){
            $query->whereIn('website_id', $filterPw);
        });
    }
}