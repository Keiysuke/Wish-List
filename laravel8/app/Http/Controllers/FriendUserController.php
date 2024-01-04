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

    function get_profile(int $user_id){
        $user = User::find($user_id);
        $user->is_friend = $user->is_friend();

        $returnHTML = view('partials.friends.profile', compact('user'))->render();
        return response()->json(['success' => true, 'html' => $returnHTML, 'is_friend' => $user->is_friend]);
    }

    function requesting(int $friend_id){
        $user = User::find(auth()->user()->id);
        $friend = User::find($friend_id);

        if($friend->is_friend())
            return response()->json(['success' => false, 'notyf' => Notyf::get('He\'s already your friend')]);

        $friend->notify(new FriendRequest($user, $friend));
        return response()->json(['success' => true, 'notyf' => Notyf::success('Friend request send')]);
    }

    function remove(int $friend_id){
        $user_id = auth()->user()->id;

        if(!User::find($friend_id)->is_friend())
            return response()->json(['success' => false, 'notyf' => Notyf::get('Incorrect action')]);
        
        FriendUser::whereIn('user_id', [$user_id, $friend_id])
            ->whereIn('friend_id', [$user_id, $friend_id])
            ->delete();

        return response()->json(['success' => true, 'notyf' => Notyf::success('Friend removed'), 'user_id' => $friend_id]);
    }
    
    function end_request(int $user_id, int $friend_id, string $status) {
        //Checking this request is for the current user
        if ($friend_id != auth()->user()->id)
            return response()->json(['success' => false, 'notyf' => Notyf::get('Incorrect action')]);

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
            $notif = Notyf::success('Friend request accepted');
        }
        return response()->json([
            'success' => true,
            'notyf' => $notif
        ]);
    }

    function filter(Request $request) {
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
                self::whereIsFriend($buildRequest, $user);

            } else {// He can be anyone
                self::whereIsNotFriend($buildRequest, $user);
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

    static function whereIsFriend(&$buildRequest, $user) {
        $buildRequest->where(function($query) use($user) {
            $query->whereHas('friends', function($q) use($user) {
                $q->where('friend_id', '=', $user->id)
                    ->orWhere('user_id', '=', $user->id);
            })
            ->orWhereHas('users', function($q) use($user) {
                $q->where('friend_id', '=', $user->id)
                    ->orWhere('user_id', '=', $user->id);
            });
        });
    }

    static function whereIsNotFriend(&$buildRequest, $user) {
        $buildRequest->whereDoesntHave('friends', function($q) use($user) {
            $q->where('friend_id', '=', $user->id)
                ->orWhere('user_id', '=', $user->id);
        })
        ->whereDoesntHave('users', function($q) use($user) {
            $q->where('friend_id', '=', $user->id)
                ->orWhere('user_id', '=', $user->id);
        });
    }
}
