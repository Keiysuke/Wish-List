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
    public function filter_historic(Request $request){
        if ($request->ajax()) {
            $this->validate($request, [
                'user_id' => 'bail|required|int',
                'date_from' => 'bail|nullable|date',
                'date_to' => 'bail|nullable|date',
                'kind' => 'bail|required|string',
            ]);
            
            $date_from = is_null($request->date_from)? '1970-01-01' : $request->date_from;
            $date_to = is_null($request->date_to)? '3000-01-01' : $request->date_to;
            $user_id = $request->user_id;
            $kind = $request->kind;
            $totals = [];
            if($kind === "purchases"){
                $purchases = Purchase::where('user_id', '=', $user_id)
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
                $group_buys = GroupBuy::where('user_id', '=', $user_id)
                    ->where('date', '>=', $date_from)
                    ->where('date', '<=', $date_to)
                    ->orderBy('date', 'desc')
                    ->get();
                foreach($group_buys as $data){
                    $data->kind = 'group_buy';
                    $data->date_used = strtotime($data->date);
                    $data->date_show = __('Purchased on').' '.date('d F Y', $data->date_used);
                    $data->cost = $data->global_cost + $data->shipping_fees - $data->discount;
                    $data->purchases = $data->grouped_purchases();
                }
                $datas = $purchases->concat($group_buys);
            }else{
                $datas = Selling::where('user_id', '=', $user_id)
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
            $datas->use_ajax = true; //Permet l'utilsation du système de pagination en ajax

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

    public function filter_benefits(Request $request){
        if ($request->ajax()) {
            $this->validate($request, [
                'user_id' => 'bail|required|int',
                'date_from' => 'bail|nullable|date',
                'date_to' => 'bail|nullable|date',
                'nb_results' => 'bail|required',
            ]);
            
            $date_from = is_null($request->date_from)? '1970-01-01' : $request->date_from;
            $date_to = is_null($request->date_to)? '3000-01-01' : $request->date_to;
            $user_id = $request->user_id;
            $nb_results = $request->nb_results === 'all' ? -1 : $request->nb_results;
            
            $totals = [
                'paid' => 0,
                'sold' => 0,
                'benefits' => 0,
            ];

            /* Managing filters sent */
            $filter_pw = [];
            $filter_tag = ['in' => [], 'out' => []];
            //Filtrés par sites
            foreach($request->websites as $product_website){
                $r = explode('_', $product_website);
                $filter_pw[] = intval($r[1]);
            }
            $tags = Tag::all();
            //Filtrés par tags
            foreach($tags as $tag){
                if(in_array('tag_'.$tag->id, $request->tags)) $filter_tag['in'][] = $tag->id;
                else $filter_tag['out'][] = $tag->id;
            }
            //Ajout des tags filtrés
            if (!is_null($request->tag_in) && !in_array($request->tag_in, $filter_tag['in'])) {
                $filter_tag['in'][] = $request->tag_in;
            }
            if (!is_null($request->tag_out) && !in_array($request->tag_out, $filter_tag['out'])) {
                $filter_tag['out'][] = $request->tag_out;
            }

            /* Creating the query */
            $buildRequest = Purchase::query();
            $buildRequest->where('user_id', '=', $user_id)
                ->where('date', '>=', $date_from)
                ->where('date', '<=', $date_to);
            
            //Filter on tags
            if($request->no_tag){
                $buildRequest->whereHas('product', function($query) {
                    $query->wheredoesntHave('tags');
                });
                
            }elseif(count($filter_tag['in']) > 0){
                $buildRequest->whereHas('product', function($query) use ($filter_tag){
                    $query->whereHas('tags', function($q) use ($filter_tag) {
                        $q->whereIn('tag_id', $filter_tag['in']);
                    });
                });
                if($request->exclusive_tags){
                    $buildRequest->whereDoesntHave('product', function($query) use ($filter_tag){
                        $query->whereHas('tags', function($q) use ($filter_tag) {
                            $q->whereIn('tag_id', $filter_tag['out']);
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
            $buildRequest->whereHas('website', function($query) use ($filter_pw){
                $query->whereIn('website_id', $filter_pw);
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
            $datas->use_ajax = true; //Permet l'utilsation du système de pagination en ajax

            $returnHTML = view('lists.historic.benefits')->with(compact('datas', 'totals', 'paginator'))->render();
            return response()->json(['success' => true, 'html' => $returnHTML]);
        }
        abort(404);
    }
}
