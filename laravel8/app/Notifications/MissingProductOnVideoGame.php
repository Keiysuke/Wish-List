<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\VideoGame;
use App\Models\User;

class MissingProductOnVideoGame extends Notification
{
    use Queueable;

    protected $user;
    protected $videoGame;

    public function __construct(VideoGame $videoGame, User $user)
    {
        $this->videoGame = $videoGame;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'video_game_id' => $this->videoGame->id,
            'user_id' => $this->user->id,
            'video_game_label' => $this->videoGame->label,
        ];
    }
}
