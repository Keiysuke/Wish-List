<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\GroupBuy;
use App\Models\Selling;
use App\Models\SellState;
use App\Models\Tag;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function filterHistoric(Request $request){
        if ($request->ajax()) {
            $this->validate($request, [
                'user_id' => 'bail|required|int',
                'date_from' => 'bail|nullable|date',
                'date_to' => 'bail|nullable|date',
                'kind' => 'bail|required|string',
            ]);
            
            $date_from = is_null($request->date_from)? '1970-01-01' : $request->date_from;
            $date_to = is_null($request->date_to)? '3000-01-01' : $request->date_to;
            $userId = $request->user_id;
            $kind = $request->kind;
            $totals = [];
            if($kind === "purchases"){
                $purchases = Purchase::where('user_id', '=', $userId)
                    ->where('date', '>=', $date_from)
                    ->where('date', '<=', $date_to)
                    ->doesnthave('group_buy_purchases')
                    ->orderBy('date', 'desc')
                    ->get();
                foreach($purchases as $data){
                    $data->kind = 'purchase';
                    $data->date_used = strtotime($data->date);
                    $data->date_show = __('Purchased on').' '.date('d F Y', $data->date_used);
                }
                $groupBuys = GroupBuy::where('user_id', '=', $userId)
                    ->where('date', '>=', $date_from)
                    ->where('date', '<=', $date_to)
                    ->orderBy('date', 'desc')
                    ->get();
                foreach($groupBuys as $data){
                    $data->kind = 'group_buy';
                    $data->date_used = strtotime($data->date);
                    $data->date_show = __('Purchased on').' '.date('d F Y', $data->date_used);
                    $data->cost = $data->global_cost + $data->shipping_fees - $data->discount;
                    $data->purchases = $data->grouped_purchases();
                    //Ajout des frais de douane
                    $data->customs = 0;
                    foreach($data->purchases as $purchase){
                        $data->customs += $purchase->customs;
                    }
                    $data->cost += $data->customs;
                    $data->explainCost = 'Coût + Fdp + Douane - Réduc : '.$data->global_cost.' + '.$data->shipping_fees.' + '.$data->customs.' - '.$data->discount;
                }
                $datas = $purchases->concat($groupBuys);
            }else{
                $datas = Selling::where('user_id', '=', $userId)
                    ->where('sell_state_id', '=', 5)
                    ->where('date_sold', '>=', $date_from)
                    ->where('date_sold', '<=', $date_to)
                    ->orderBy('date_sold', 'desc')
                    ->get();
                foreach($datas as $data){
                    $data->kind = 'selling';
                    $data->date_used = strtotime($data->date_sold);
                    $data->date_show = __('Sold on').' '.date('d F Y', $data->date_used);
                    $data->cost = $data->confirmed_price + $data->shipping_fees - $data->shipping_fees_payed;
                }
            }

            foreach($datas as $data){ //Setting the date for each data we've just got
                $data->simple = !($data->kind === 'group_buy');
                $data->month = date('F', $data->date_used);
                $data->year = date('Y', $data->date_used);
                if(array_key_exists($data->year.'_'.$data->month, $totals)) $totals[$data->year.'_'.$data->month] += $data->cost;
                else $totals[$data->year.'_'.$data->month] = $data->cost;
            }
            $datas = $datas->sortBy('date_used', 1, true)->paginate(15);
            $paginator = (object)['cur_page' => $datas->links()->paginator->currentPage()];
            $datas->useAjax = true; //Permet l'utilisation du système de pagination en ajax

            $returnHTML = view('lists.historic.'.$kind)->with(compact('datas', 'totals', 'paginator'))->render();
            return response()->json(['success' => true, 'html' => $returnHTML]);
        }
        abort(404);
    }

    public function historic($kind){
        if(!in_array($kind, ['purchases', 'sellings']))
            return redirect()->route('home');

        $purchases = $kind === 'purchases';
        return view('users/historic', compact('kind', 'purchases'));
    }
    
    public function benefits(Request $request){
        $filters = (object)['purchased' => 'purchased_all', 'stock' => request('stock', 'product_all'), 'tag_in' => request('tag_in', 0)];
        return view('users/benefits', compact('filters'));
    }

    public function filterBenefits(Request $request){
        if ($request->ajax()) {
            $this->validate($request, [
                'user_id' => 'bail|required|int',
                'date_from' => 'bail|nullable|date',
                'date_to' => 'bail|nullable|date',
                'nb_results' => 'bail|required',
            ]);
            
            $date_from = is_null($request->date_from)? '1970-01-01' : $request->date_from;
            $date_to = is_null($request->date_to)? '3000-01-01' : $request->date_to;
            $userId = $request->user_id;
            $nb_results = $request->nb_results === 'all' ? -1 : $request->nb_results;
            
            $totals = [
                'paid' => 0,
                'sold' => 0,
                'benefits' => 0,
            ];

            /* Managing filters sent */
            $filterPw = [];
            $filterTag = ['in' => [], 'out' => []];
            //Filtrés par sites
            foreach($request->websites as $product_website){
                $r = explode('_', $product_website);
                $filterPw[] = intval($r[1]);
            }
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

            /* Creating the query */
            $buildRequest = Purchase::query();
            $buildRequest->where('user_id', '=', $userId)
                ->where('date', '>=', $date_from)
                ->where('date', '<=', $date_to);
            
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
            
            //Filtrés par produits achetés ou vendus
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

            //Filter on Websites
            $buildRequest->whereHas('website', function($query) use ($filterPw){
                $query->whereIn('website_id', $filterPw);
            });

            $datas = $buildRequest->orderBy('date', 'desc')
                ->limit($nb_results)
                ->get();

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
            $datas = $datas->sortBy(['website_id'], 1, true)->paginate($nb_results);
            $paginator = (object)['cur_page' => $datas->links()->paginator->currentPage()];
            $datas->useAjax = true; //Permet l'utilisation du système de pagination en ajax

            $returnHTML = view('lists.historic.benefits')->with(compact('datas', 'totals', 'paginator'))->render();
            return response()->json(['success' => true, 'html' => $returnHTML]);
        }
        abort(404);
    }
}
