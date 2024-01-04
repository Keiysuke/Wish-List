<?php

namespace App\Notifications;

use App\Models\Listing;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\User;

class ShareList extends Notification
{
    use Queueable;

    protected $user;
    protected $list;

    public function __construct(User $user, Listing $list)
    {
        $this->user = $user;
        $this->list = $list;
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
            'list_id' => $this->list->id,
            'list_name' => $this->list->label,
        ];
    }
}
