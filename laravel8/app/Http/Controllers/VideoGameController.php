<?php

namespace App\Http\Controllers;

use App\Http\Requests\PsnVgRequest;
use App\Http\Requests\VgFilterRequest;
use Illuminate\Http\Request;
use App\Http\Requests\VideoGameRequest;
use App\Models\Notyf;
use App\Models\ProductAsVideoGame;
use App\Models\VideoGame;
use App\Services\DateService;
use App\Services\Filters\VgFilterService;
use App\Services\VideoGameService;

class VideoGameController extends Controller
{
    private $nb_page_results = 15;
    
    public function exists($label, $vgId = null){
        if(is_null($vgId)) return VideoGame::where("label", $label)->exists();
        else return VideoGame::where('label', $label)->where('id', '<>', $vgId)->exists();
    }

    public function index(Request $request){
        //Si la mise à jour des notifications n'a pas été faite
        app('App\\Http\\Controllers\\NotificationsController')->checkProductNotifications();
        app('App\\Http\\Controllers\\NotificationsController')->checkVideoGameNotifications();
        app('App\\Http\\Controllers\\NotificationsController')->checkCrowdfundingNotifications();
        
        $sortBy = (object)['kind' => 'date', 'order' => 'desc', 'list' => 'grid', 'show_archived' => 0];
        $filters = (object)['purchased' => 'purchased_all', 'f_nb_results' => $this->nb_page_results];
        $search = $request->search;

        $buildRequest = VideoGame::query();
        // if($request->path() === 'video_games/user'){
        //     $buildRequest->whereHas('users', function($query){
        //         $query->where('user_id', '=', auth()->user()->id);
        //     });
        // }else{
        //     $buildRequest->whereHas('users', function($query){
        //         $query->where('user_id', '<>', auth()->user()->id);
        //     });
        // }

        if(!is_null($search)) $buildRequest->where('label', 'like', '%'.$search.'%');
        $videoGames = $buildRequest->orderBy('created_at', $sortBy->order)->paginate($this->nb_page_results);

        if ($request->query('fast_search') && count($videoGames) === 1) {
            return redirect()->route('video_games.show', $videoGames->first()->id);
        }
        
        $paginator = (object)['cur_page' => $videoGames->links()->paginator->currentPage()];
        $videoGames->useAjax = true; //Permet l'utilisation du système de pagination en ajax
        
        return view('video_games.index', compact('videoGames', 'sortBy', 'filters', 'search', 'paginator'));
    }

    function filter(VgFilterRequest $request){
        abort_unless($request->ajax(), 404);
        $videoGames = (new VgFilterService())->applyFilters($request);
        $videoGames->useAjax = true; //Permet l'utilisation du système de pagination en ajax
        
        $html = view('partials.video_games.'.$request->list.'_details', compact('videoGames'))->render();
        return response()->json(['success' => true, 'nb_results' => $videoGames->links()? $videoGames->links()->paginator->total() : count($videoGames), 'html' => $html]);
    }

    public function create(){
        $today = DateService::today();
        return view('video_games.create', compact('today'));
    }

    public function store(VideoGameRequest $request){
        try {
            $videoGame = app(VideoGameService::class)->createFromRequest($request);
        } catch (\Exception $e) {
            return back()->withErrors(['label' => $e->getMessage()])->withInput();
        }
        return redirect()->route('video_games.edit', $videoGame->id)->with('info', __('The video game has been created.'));
    }

    public function createPsn(){
        $today = DateService::today();
        return view('video_games.psn.create', compact('today'));
    }

    public function storePsn(PsnVgRequest $request){
        try {
            for ($i = 0; $i < 3; $i++) {
                $request->merge([
                    'label' => $request->input('label_' . $i),
                    'developer_id' => $request->input('developer_id_' . $i),
                    'date_released' => $request->input('date_released_' . $i),
                    'nb_players' => $request->input('nb_players_' . $i),
                ]);
                $videoGame = app(VideoGameService::class)->createPsnFromRequest($request);

                //On crée le produit pour le jeu vidéo PSN
                UtilsController::createProductFromPsPlus($videoGame, $request->input('ps_month'), $request->input('ps_year'));
            }
        } catch (\Exception $e) {
            return back()->withErrors(['label' => $e->getMessage()])->withInput();
        }
        return redirect()->route('video_games.index')->with('info', __('The video games has been created.'));
    }

    public function show(VideoGame $videoGame){
        $products = $videoGame->products;
        $product = $videoGame->product();
        $photos = is_null($product)? [asset('resources/images/no_pict.png')] : $product->photos()->orderBy('ordered')->get();
        
        return view('video_games.show', compact('videoGame', 'photos', 'product', 'products'));
    }
    
    public function edit(VideoGame $videoGame){
        return view('video_games.edit', compact('videoGame'));
    }
    
    public function update(VideoGameRequest $request, VideoGame $videoGame){
        if($this->exists($request->label, $videoGame->id))
            return back()->withErrors(['label' => __('That video game already exists.')])->withInput(); //Redirect back with a custom error and older Inputs
        
        $videoGame->update($request->all());
        return redirect()->route('video_games.edit', $videoGame)->with('info', __('The video game has been edited.'));
    }

    public function unlinkProduct(int $productId){
        ProductAsVideoGame::where('product_id', '=', $productId)->delete();
        return response()->json(['success' => true, 'notyf' => Notyf::success('The product has been unlinked')]);
    }
}
