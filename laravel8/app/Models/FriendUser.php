<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class FriendUser extends Model{
    use HasFactory;
    protected $fillable = ['user_id', 'friend_id', 'favorite'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id', 'user_id');
    }

    public function friend(){
        return $this->belongsTo(User::class, 'friend_id', 'id', 'user_id');
    }

    public function getRequests(){
        $user = User::find(auth()->user()->id);

        $friend_request = $user->notifications()
            ->where('type', '=', 'App\Notifications\FriendRequest')
            ->whereJsonContains('data->friend_id', $user->id);
        return $friend_request;
    }
}
