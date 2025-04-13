<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\VideoGameRequest;
use App\Models\Notyf;
use App\Models\ProductAsVideoGame;
use App\Models\VgSupport;
use App\Models\VideoGame;
use App\Services\DateService;
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
        app('App\Http\Controllers\NotificationsController')->checkProductNotifications();
        app('App\Http\Controllers\NotificationsController')->checkVideoGameNotifications();
        
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

    function filter(Request $request){
        if ($request->ajax()) {
            $this->validate($request, [
                'search_text' => 'bail|nullable|string',
                'sort_by' => 'bail|required|string',
                'order_by' => 'bail|required|string',
                'page' => 'bail|required|int',
                'purchased' => 'bail|required|string',
                'f_nb_results' => 'bail|required|int',
            ]);
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
            $filterSupport = [];
            //Filtrés par support JV
            foreach($request->vg_supports as $support){
                $r = explode('vg_support_', $support);
                $filterSupport[] = intval($r[1]);
            }

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

            //Filter on vg_supports
            if(!count($filterSupport)){
                $buildRequest->wheredoesntHave('vg_supports');
                
            }elseif(strcmp(count($filterSupport), VgSupport::count())){
                $buildRequest->whereHas('vg_supports', function($query) use ($filterSupport){
                    $query->whereIn('vg_support_id', $filterSupport);
                });
            }
            
            $buildRequest->where('label', 'like', '%'.$request->search_text.'%');

            $videoGames = $buildRequest->orderBy($sortBy, $request->order_by)->paginate($request->f_nb_results);
            $videoGames->useAjax = true; //Permet l'utilisation du système de pagination en ajax
            
            $html = view('partials.video_games.'.$request->list.'_details')->with(compact('videoGames'))->render();
            return response()->json(['success' => true, 'nb_results' => $videoGames->links()? $videoGames->links()->paginator->total() : count($videoGames), 'html' => $html]);
        }
        abort(404);
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
