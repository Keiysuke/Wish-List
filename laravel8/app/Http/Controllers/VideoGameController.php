<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\VideoGameRequest;
use App\Models\Notyf;
use App\Models\ProductAsVideoGame;
use App\Models\VgSupport;
use App\Models\VideoGame;

class VideoGameController extends Controller
{
    private $nb_page_results = 15;
    
    public function exists($lbl, $id = null){
        if(is_null($id)) return VideoGame::where("label", $lbl)->exists();
        else return VideoGame::where('label', $lbl)->where('id', '<>', $id)->exists();
    }

    public function index(Request $request){
        //Si la mise à jour des notifications n'a pas été faite
        app('App\Http\Controllers\NotificationsController')->checkProductNotifications();
        
        $sortBy = (object)['kind' => 'date', 'order' => 'desc', 'list' => 'grid', 'show_archived' => 0];
        $filters = (object)['purchased' => 'purchased_all', 'f_nb_results' => $this->nb_page_results];
        $search = $request->search;

        $buildRequest = VideoGame::query();
        // if($request->path() === 'video_games/user'){
        //     $buildRequest->whereHas('users', function($query){
        //         $query->where('user_id', '=', Auth::user()->id);
        //     });
        // }else{
        //     $buildRequest->whereHas('users', function($query){
        //         $query->where('user_id', '<>', Auth::user()->id);
        //     });
        // }

        if(!is_null($search)) $buildRequest->where('label', 'like', '%'.$search.'%');
        $video_games = $buildRequest->orderBy('created_at', $sortBy->order)->paginate($this->nb_page_results);

        if ($request->query('fast_search') && count($video_games) === 1) {
            return redirect()->route('video_games.show', $video_games->first()->id);
        }
        
        $paginator = (object)['cur_page' => $video_games->links()->paginator->currentPage()];
        $video_games->use_ajax = true; //Permet l'utilsation du système de pagination en ajax
        
        return view('video_games.index', compact('video_games', 'sortBy', 'filters', 'search', 'paginator'));
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
                case 'alpha': $sort_by = 'label';
                    break;
                case 'players': $sort_by = 'nb_players';
                    break;
                case 'date_released': $sort_by = 'date_released';
                    break;
                default: $sort_by = 'created_at';
            }

            $buildRequest = VideoGame::query();
            $filter_support = [];
            //Filtrés par support JV
            foreach($request->vg_supports as $support){
                $r = explode('vg_support_', $support);
                $filter_support[] = intval($r[1]);
            }

            // if($request->url === 'video_games/user'){
            //     $buildRequest->whereHas('users', function($query){
            //         $query->where('user_id', '=', Auth::user()->id);
            //     });
            // }else{
            //     $buildRequest->whereHas('users', function($query){
            //         $query->whereNotIn('product_id', function($query){
            //             $query->select('product_id')->from('product_users')->where('user_id', '=', Auth::user()->id);
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
            if(!count($filter_support)){
                $buildRequest->wheredoesntHave('vg_supports');
                
            }elseif(strcmp(count($filter_support), VgSupport::count())){
                $buildRequest->whereHas('vg_supports', function($query) use ($filter_support){
                    $query->whereIn('vg_support_id', $filter_support);
                });
            }
            
            $buildRequest->where('label', 'like', '%'.$request->search_text.'%');

            $video_games = $buildRequest->orderBy($sort_by, $request->order_by)->paginate($request->f_nb_results);
            $video_games->use_ajax = true; //Permet l'utilsation du système de pagination en ajax
            
            $returnHTML = view('partials.video_games.'.$request->list.'_details')->with(compact('video_games'))->render();
            return response()->json(['success' => true, 'nb_results' => $video_games->links()? $video_games->links()->paginator->total() : count($video_games), 'html' => $returnHTML]);
        }
        abort(404);
    }

    public function create(){
        return view('video_games.create');
    }

    public function store(VideoGameRequest $request){
        if($this->exists($request->label))
            return back()->withErrors(['label' => __('That video game already exists.')])->withInput(); //Redirect back with a custom error and older Inputs

        $video_game = new VideoGame([
            'developer_id' => $request->developer_id, 
            'label' => $request->label, 
            'date_released' => $request->date_released,
            'nb_players' => $request->nb_players,
        ]);
        $video_game->save();
        return redirect()->route('video_games.edit', $video_game->id)->with('info', __('The video game has been created.'));
    }

    public function show(VideoGame $video_game){
        $products = $video_game->products;
        $product = $video_game->product();
        $photos = is_null($product)? [asset('resources/images/no_pict.png')] : $product->photos()->orderBy('ordered')->get();
        
        return view('video_games.show', compact('video_game', 'photos', 'product', 'products'));
    }
    
    public function edit(VideoGame $video_game){
        return view('video_games.edit', compact('video_game'));
    }
    
    public function update(VideoGameRequest $request, VideoGame $video_game){
        if($this->exists($request->label, $video_game->id))
            return back()->withErrors(['label' => __('That video game already exists.')])->withInput(); //Redirect back with a custom error and older Inputs
        
        $video_game->update($request
            ->merge([
                'developer_id' => $request->developer_id, 
                'label' => $request->label, 
                'date_released' => $request->date_released,
                'nb_players' => $request->nb_players,
            ])
            ->all()
        );
        return redirect()->route('video_games.edit', $video_game)->with('info', __('The video game has been edited.'));
    }

    public function unlink_product(int $id){
        ProductAsVideoGame::where('product_id', '=', $id)->delete();
        return response()->json(['success' => true, 'notyf' => Notyf::success('The product has been unlinked')]);
    }
}
