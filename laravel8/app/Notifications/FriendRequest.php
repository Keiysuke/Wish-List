<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\User;

class FriendRequest extends Notification
{
    use Queueable;

    protected $user;
    protected $friend;

    public function __construct(User $user, User $friend)
    {
        $this->friend = $friend;
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'friend_id' => $this->friend->id,
            'friend_name' => $this->friend->name,
        ];
    }
}
