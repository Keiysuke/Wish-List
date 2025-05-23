<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\ListingProduct;
use App\Models\ListingUser;
use App\Models\User;
use App\Http\Requests\ListingRequest;
use App\Models\Notyf;
use App\Models\Product;
use App\Notifications\Lists\ListLeft;
use App\Notifications\Lists\Products\ProductRemoved;
use App\Services\MessageService;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    public function toggleProduct(Request $request){
        if ($request->ajax()) {
            $this->validate($request, [
                'list_id' => 'bail|required|int',
                'product_id' => 'bail|required|int',
                'nb' => 'bail|nullable|int',
                'change_checked' => 'bail|nullable|boolean'
            ]);
            $list = Listing::find($request->list_id);
            $newProduct = false;
            
            // Produit ajouté ou retiré (via page du produit)
            if($request->change_checked) {
                $list->products()->toggle([$request->product_id]);
                $products = $list->getProducts(false, true);
                $hasProduct = $products->find($request->product_id);
                $product = Product::find($request->product_id);
                if ($hasProduct) {
                    $newProduct = true;
                } else {
                    foreach ($list->users as $user) {
                        $user->notify(new ProductRemoved($user, $list, $product));
                    }
                }
            } else {
                $products = $list->getProducts(false, true);
                $hasProduct = $products->find($request->product_id);
            }
            
            //On met à jour les données seulement si le produit est toujours dans la liste
            if ($hasProduct && isset($request->nb)) {
                $list->updateProductNb($request, $newProduct);
            }
            
            $products = $list->getProducts();
            return response()->json(array('success' => true, 'total_price' => $products->total_price, 'total_best_price' => $products->total_best_price));
        }
    }

    public function showProducts(int $listId){
        $list = Listing::find($listId);
        $products = $list->getProducts();
        $friends = $list->getFriendsNotShared();
        
        $messagesHTML = (new MessageService())->show($listId);
        
        $nb_results = $products->links()? $products->links()->paginator->total() : count($products);
        $html = view('partials.lists.products', compact('products', 'list', 'friends', 'nb_results'))->render();
        return response()->json([
            'success' => true, 
            'nb_results' => $nb_results, 
            'html' => $html,
            'shared_list' => $list->isShared(),
            'htmlMsg' => $messagesHTML
        ]);
    }

    public function index(){
        $lists = Listing::where('user_id', '=', auth()->user()->id)
            ->orderBy('listing_type_id')
            ->orderBy('label')
            ->get();
        return view('lists.index', compact('lists'));
    }

    public function create(){
        return view('lists.create');
    }

    public function store(ListingRequest $request){
        Listing::create(
            $request->merge([
                'secret' => $request->has('secret')? 1 : 0,
            ])->all()
        );
        return redirect()->route('lists.index')->with('info', __('The list has been created.'));
    }

    public function getUserLists(int $userId){
        $messagesHTML = null;
        $firstList = null;
        if ($userId === 0) {//Listes des amis
            $lists = auth()->user()->getFriendLists();
            $usersName = [];
            $listingUsers = [];
            foreach ($lists as $list) {
                if (is_null($firstList)) $firstList = $list;
                if (array_key_exists($list->user_id, $listingUsers)) {
                    $listingUsers[$list->user_id][] = $list;
                } else {
                    $listingUsers[$list->user_id] = [$list];
                    $usersName[$list->user_id] = $list->user->name;
                }
            }
            
            $messagesHTML = (new MessageService())->show($firstList->id);

            $html = view('partials.lists.others', compact('listingUsers', 'usersName'))->render();

        } else {
            $typesLabel = [];
            $listingTypes = [];
            $lists = Listing::where('user_id', '=', $userId)->orderBy('listing_type_id')->orderBy('label')->get();
            foreach ($lists as $list) {
                if (is_null($firstList)) $firstList = $list;
                if (array_key_exists($list->listing_type_id, $listingTypes)) {
                    $listingTypes[$list->listing_type_id][] = $list;
                } else {
                    $listingTypes[$list->listing_type_id] = [$list];
                    $typesLabel[$list->listing_type_id] = $list->listing_type->label;
                }
            }
            $html = view('partials.lists.mine', compact('listingTypes', 'typesLabel'))->render();
        }
        return response()->json([
            'success' => true, 
            'html' => $html,
            'first_list_id' => $firstList->id,
            'shared_list' => $firstList->isShared(),
            'htmlMsg' => $messagesHTML
        ]);
    }

    public function edit(Listing $list){
        return view('lists.edit', compact('list'));
    }

    public function update(Request $request, Listing $list){
        $list->update($request
            ->merge([
                'secret' => ($request->has('secret')? 1 : 0)])
            ->all()
        );
        return redirect()->route('lists.index')->with('info', __('The list has been edited.'));
    }

    public function destroy(int $listId){
        $list = Listing::find($listId);
        foreach($list->products as $product){ //Suppression des associations aux produits de la liste
            ListingProduct::where('listing_id', '=', $list->id)->where('product_id', '=', $product->id)->delete();
        }
        foreach($list->users as $user){ //Suppression des associations aux utilisateurs ayant accès à la liste
            ListingUser::where('listing_id', '=', $list->id)->where('user_id', '=', $user->id)->delete();
        }
        $list->delete();
        $firstList = Listing::where('user_id', '=', auth()->user()->id)->orderBy('label')->first();
        $firstListId = is_null($firstList)? -1 : $firstList->id;
        return response()->json([
            'success' => true, 
            'deletedId' => $listId, 
            'listId' => $firstListId,
            'notyf' => Notyf::success('The list has been deleted')
        ]);
    }

    public function download(int $listId){
        $products = Listing::find($listId)->getProducts();
        return response()->json([
            'success' => true, 
            'blob' => view('exports.list', compact('products'))->render(), 
            'filename' => Listing::getFileName($listId)
        ]);
    }

    function leave(int $listId) {
        $list = Listing::find($listId);
        $authUser = User::find(auth()->user()->id);
        ListingUser::where('listing_id', $listId)
            ->where('user_id', $authUser->id)
            ->delete();
        
        //On informe le propriétaire
        (User::find($list->user_id))->notify(new ListLeft($authUser, Listing::find($listId), false));
        return response()->json([
            'success' => true,
        ]);
    }
    
    public function showEditProduct(int $listId, int $productId){
        $productList = ListingProduct::where('listing_id', $listId)
            ->where('product_id', $productId)
            ->firstOrFail();
        
        $html = view('partials.lists.edit_product', compact('productList'))->render();
        
        return response()->json([
            'success' => true, 
            'html' => $html
        ]);
    }
}
