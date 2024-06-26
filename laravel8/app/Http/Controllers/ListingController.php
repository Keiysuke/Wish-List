<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\ListingProduct;
use App\Models\ListingUser;
use App\Models\User;
use App\Http\Requests\ListingRequest;
use App\Models\Notyf;
use App\Notifications\ListLeft;
use App\Notifications\ShareList;
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
            if($request->change_checked) $list->products()->toggle([$request->product_id]);
            //Setting nb only if the product is still linked to that list
            $products = $list->getProducts(false);
            $hasProduct = $products->find($request->product_id);
            if($hasProduct && isset($request->nb)){
                ListingProduct::where('listing_id', '=', $request->list_id)
                    ->where('product_id', '=', $request->product_id)
                    ->update(['nb' => $request->nb]);
            }
            
            $products = $list->getProducts();
            return response()->json(array('success' => true, 'total_price' => $products->total_price));
        }
    }

    public function showProducts(int $listId){
        $list = Listing::find($listId);
        $products = $list->getProducts();
        $friends = $list->getFriendsNotShared();
        
        $messagesHTML = (new MessageService())->show($listId);
        
        $nb_results = $products->links()? $products->links()->paginator->total() : count($products);
        $returnHTML = view('partials.lists.products')->with(compact('products', 'list', 'friends', 'nb_results'))->render();
        return response()->json([
            'success' => true, 
            'nb_results' => $nb_results, 
            'html' => $returnHTML,
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
        $list = new Listing([
            'user_id' => $request->user_id,
            'listing_type_id' => $request->listing_type_id,
            'label' => $request->label,
            'description' => $request->description,
            'secret' => $request->has('secret')? 1 : 0,
        ]);
        $list->save();
        return redirect()->route('lists.index')->with('info', __('The list has been created.'));
    }

    public function getUserLists(int $userId){
        $messagesHTML = null;
        $firstList = null;
        if ($userId === 0) {//Listes des amis
            $lists = Listing::select('listings.*')
                ->join('listing_users', 'listings.id', '=', 'listing_users.listing_id')
                ->where('listing_users.user_id', '=', auth()->user()->id)
                ->join('users', 'listings.user_id', '=', 'users.id')
                ->orderBy('users.name')
                ->get();
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

            $returnHTML = view('partials.lists.others')->with(compact('listingUsers', 'usersName'))->render();

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
            $returnHTML = view('partials.lists.mine')->with(compact('listingTypes', 'typesLabel'))->render();
        }
        return response()->json([
            'success' => true, 
            'html' => $returnHTML,
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
            ->merge(['listing_type_id' => $request->listing_type_id,
                'label' => $request->label,
                'description' => $request->description,
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

    public function showShare(int $listId){
        $list = Listing::find($listId);
        $friends = $list->getFriendsNotShared();
        
        $returnHTML = view('partials.lists.share_friends')->with(compact('list', 'friends'))->render();
        return response()->json([
            'success' => true, 
            'html' => $returnHTML
        ]);
    }

    public function share(Request $request){
        if ($request->ajax()) {
            $this->validate($request, ['list_id' => 'bail|required|int']);
            $listId = $request->list_id;
            $user = auth()->user();

            $notifs = 0;
            foreach ($request->friends as $friend_id) {
                $friend = User::find($friend_id);
                (new ListingUser([
                    'listing_id' => $listId,
                    'user_id' => $friend_id,
                    ]))->save();
                //Check if the friend has already been notified or not
                $exist = $friend->notifications()
                    ->where('type', '=', 'App\Notifications\ShareList')
                    ->whereJsonContains('data->list_id', $listId)
                    ->whereJsonContains('data->user_id', $user->id)
                    ->first();
                if (!$exist) {
                    $notifs++;
                    $friend->notify(new ShareList($user, Listing::find($listId)));
                }
            }

            if ($notifs > 0) {
                return response()->json([
                    'success' => true, 
                    'notyf' => Notyf::success('Your friend can now access your list')
                ]);
            } else {
                return response()->json([
                    'success' => false, 
                    'notyf' => Notyf::warning('These friends can already access your list')
                ]);
            }
        }
    }

    function leave(int $listId) {
        $list = Listing::find($listId);
        $authUser = User::find(auth()->user()->id);
        ListingUser::where('listing_id', '=', $listId)
            ->where('user_id', '=', $authUser->id)
            ->delete();
        
        //On informe le propriétaire
        (User::find($list->user_id))->notify(new ListLeft($authUser, Listing::find($listId), false));
        return response()->json([
            'success' => true,
        ]);
    }
}
