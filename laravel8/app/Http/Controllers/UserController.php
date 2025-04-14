<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserBenefitsRequest;
use App\Http\Requests\UserHistoricRequest;
use App\Services\Filters\UserBenefitsFilterService;
use App\Services\Filters\UserHistoricFilterService;
use Illuminate\Http\Request;

class UserController extends Controller
{
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

    public function filterHistoric(UserHistoricRequest $request){
        abort_unless($request->ajax(), 404);
        
        $totals = [];
        $kind = $request->kind;
        $userHistoricFilterService = new UserHistoricFilterService();
        $datas = $userHistoricFilterService->applyFilters($request, $kind);
        //On formate les données tel qu'on veut les afficher
        $userHistoricFilterService->formatResults($totals, $datas);

        $datas = $datas->sortBy('date_used', 1, true)->paginate(15);
        $paginator = (object)['cur_page' => $datas->links()->paginator->currentPage()];
        $datas->useAjax = true; //Permet l'utilisation du système de pagination en ajax

        $html = view('lists.historic.'.$kind)->with(compact('datas', 'totals', 'paginator'))->render();
        return response()->json(['success' => true, 'html' => $html]);
    }

    public function filterBenefits(UserBenefitsRequest $request){
        abort_unless($request->ajax(), 404);

        $nb_results = 15;
        $totals = [
            'paid' => 0,
            'sold' => 0,
            'benefits' => 0,
        ];
        $userBenefitsFilterService = new UserBenefitsFilterService();
        $datas = $userBenefitsFilterService->applyFilters($request, $nb_results);
        //On formate les données tel qu'on veut les afficher
        $userBenefitsFilterService->formatResults($totals, $datas);
        
        $datas = $datas->sortBy(['website_id'], 1, true)->paginate($nb_results);
        $paginator = (object)['cur_page' => $datas->links()->paginator->currentPage()];
        $datas->useAjax = true; //Permet l'utilisation du système de pagination en ajax

        $html = view('lists.historic.benefits')->with(compact('datas', 'totals', 'paginator'))->render();
        return response()->json(['success' => true, 'html' => $html]);
    }
}
