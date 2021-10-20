<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\GroupBuy;
use App\Models\Selling;
use App\Models\Product;
use Illuminate\Http\Request;
use EloquentBuilder;
use Illuminate\Support\Facades\DB;

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
}
