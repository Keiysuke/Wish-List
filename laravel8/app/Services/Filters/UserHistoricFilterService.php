<?php

namespace App\Services\Filters;

use App\Http\Requests\UserHistoricRequest;
use App\Models\GroupBuy;
use App\Models\Purchase;
use App\Models\Selling;

class UserHistoricFilterService
{
    public function applyFilters(UserHistoricRequest $request, string $kind)
    {
        $date_from = is_null($request->date_from)? '1970-01-01' : $request->date_from;
        $date_to = is_null($request->date_to)? '3000-01-01' : $request->date_to;
        $userId = $request->user_id;

        if($kind === "purchases"){
            $datas = $this->applyPurchaseFilter($date_from, $date_to, $userId);
        }else{
            $datas = $this->applySellingFilter($date_from, $date_to, $userId);
        }
        return $datas;
    }

    function formatResults(Array &$totals, Object &$datas){
        foreach($datas as $data){
            $data->simple = !($data->kind === 'group_buy');
            $data->month = date('F', $data->date_used);
            $data->year = date('Y', $data->date_used);
            if(array_key_exists($data->year.'_'.$data->month, $totals)) $totals[$data->year.'_'.$data->month] += $data->cost;
            else $totals[$data->year.'_'.$data->month] = $data->cost;
        }
    }

    function applyPurchaseFilter(string $date_from, string $date_to, int $userId){
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
        return $purchases->concat($groupBuys);
    }

    function applySellingFilter(string $date_from, string $date_to, int $userId){
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
        return $datas;
    }
}