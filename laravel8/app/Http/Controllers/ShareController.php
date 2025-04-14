<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\ListingUser;
use App\Models\Notyf;
use App\Models\Product;
use App\Models\User;
use App\Notifications\Lists\ShareList;
use App\Notifications\Friends\Share\ShareProduct;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class ShareController extends Controller
{
    public function showList(string $type, int $id){
        $model = NotificationService::getModel($type);
        $item = $model::find($id);
        if ($type === 'list') {
            $friends = $item->getFriendsNotShared();
        } else {
            $friends = auth()->user()->friends;
        }
        
        $html = view('partials.lists.share_friends')->with(compact('item', 'friends', 'type'))->render();
        return response()->json([
            'success' => true, 
            'html' => $html
        ]);
    }

    function share(Request $request){
        if ($request->ajax()) {
            $this->validate($request, ['id' => 'bail|required|int', 'type' => 'bail|required|string']);
            $id = $request->id;

            $notifs = $this->shareItem($id, $request->type, $request->friends);

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

    function shareItem(int $id, string $type, array $friends = []): int{
        $notifs = 0;
        foreach ($friends as $friendId) {
            $friend = User::find($friendId);
            $model = NotificationService::getModel($type);
            $user = auth()->user();
        
            switch ($type) {
                case 'list' : (new ListingUser([
                    'listing_id' => $id,
                    'user_id' => $friendId,
                    ]))->save();
                    break;
            }
            //Check if the friend has already been notified or not
            $exist = $friend->notifications()
                ->where('type', '=', 'App\Notifications\Share')
                ->whereJsonContains('data->id', $id)
                ->whereJsonContains('data->type', $model)
                ->whereJsonContains('data->user_id', $user->id)
                ->first();
            if (!$exist) {
                $notifs++;
                switch ($type) {
                    case 'list' : $friend->notify(new ShareList($user, Listing::find($id)));
                        break;
                    case 'product' : $friend->notify(new ShareProduct($user, Product::find($id)));
                        break;
                }
            }
        }
        return $notifs;
    }
}
