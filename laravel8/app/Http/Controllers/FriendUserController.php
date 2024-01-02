<?php

namespace App\Http\Controllers;

use App\Models\FriendUser;
use App\Models\Notyf;
use App\Models\User;
use App\Notifications\FriendRequest;
use Illuminate\Http\Request;

class FriendUserController extends Controller
{
    public function already_friend($user_id, $friend_id){
        return FriendUser::where('user_id', $user_id)->where('friend_id', $friend_id)->exists();
    }

    //Routes
    public function index(){
        return view('users.friends.index');
    }

    public function edit(FriendUser $website){
        return view('admin.websites.edit', compact('website'));
    }

    public function update(Request $request, FriendUser $website){
        if($this->exists($request->label, $website->id))
            return back()->withErrors(['label' => __('That website already exists.')])->withInput(); //Redirect back with a custom error and older Inputs

        $website->update($request
            ->merge([
                'can_sell' => ($request->has('can_sell')? 1 : 0),
                'is_vg' => ($request->has('is_vg')? 1 : 0),
            ])
            ->all()
        );
        return redirect()->route('websites.index')->with('info', __('The website has been edited.'));
    }

    public function destroy(FriendUser $website){
        $website->delete();
        return back()->with('info', __('The website has been deleted.'));
    }

    function requesting(Request $request){
        if ($request->ajax()) {
            $this->validate($request, [
                'friend_id' => 'bail|required|int',
            ]);
            $friend_id = $request->friend_id;
            $user = User::find(auth()->user()->id);
            $friend = User::find($friend_id);

            if($this->already_friend($user->id, $friend_id))
                return response()->json(['success' => false, 'notyf' => Notyf::get('He\'s already your friend')]);

            $friend->notify(new FriendRequest($user, $friend));
            return response()->json(['success' => true, 'notyf' => Notyf::get('Friend request send', Notyf::SUCCESS)]);
        }
        abort(404);
    }
    
    function end_request(Request $request, $status){
        if ($request->ajax()) {
            $this->validate($request, [
                'user_id' => 'bail|required|int',
                'friend_id' => 'bail|required|int',
            ]);
            $user_id = $request->user_id;
            $friend_id = $request->friend_id;
            
            //Checking this request is for the current user
            if ($friend_id != auth()->user()->id)
                return response()->json(['success' => false, 'notyf' => Notyf::get('That request does not concern you')]);

            //Removing the Notification
            $user = User::find($friend_id);
            $user->notifications()->where('type', '=', 'App\Notifications\FriendRequest')
                ->whereJsonContains('data->user_id', $user_id)
                ->whereJsonContains('data->friend_id', $friend_id)
                ->first()
                ->delete();
            
            $notif = Notyf::get('Friend request refused');
            if ($status === 'accept') {
                (new FriendUser([
                    'user_id' => $user_id,
                    'friend_id' => $friend_id,
                    ]))->save();
                $notif = Notyf::get('Friend request accepted', Notyf::SUCCESS);
            }
            return response()->json([
                'success' => true,
                'notyf' => $notif
            ]);
        }
        abort(404);
    }

    function filter(Request $request){
        if ($request->ajax()) {
            $this->validate($request, [
                'name' => 'bail|nullable|string',
                'is_friend' => 'bail|required|boolean',
            ]);
            $user = auth()->user();
            
            $buildRequest = User::query()
                ->where('id', '!=', $user->id)
                ->where('name', 'like', '%'.$request->name.'%');

            if ($request->is_friend) {// He must be a friend of the user
                $buildRequest->whereHas('friends', function($query) use($user) {
                    $query->where('friend_id', '=', $user->id)
                        ->orWhere('user_id', '=', $user->id);
                });

            } else {// He can be anyone
                $buildRequest->whereDoesntHave('friends', function($query) use($user) {
                    $query->where('friend_id', '=', $user->id)
                        ->orWhere('user_id', '=', $user->id);
                });
            }
            $friends = $buildRequest->orderBy('name', 'asc')->get();
            
            foreach ($friends as $friend) {
                $friend->first_letter = $friend->name[0];
            }

            $returnHTML = view('partials.friends.list', compact('friends'))->render();
            return response()->json(['success' => true, 'html' => $returnHTML, 'nb_results' => count($friends)]);
        }
        abort(404);
    }
}
