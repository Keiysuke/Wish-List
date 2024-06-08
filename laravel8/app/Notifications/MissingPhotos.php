<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Product;
use App\Models\User;

class MissingPhotos extends Notification
{
    use Queueable;

    protected $user;
    protected $product;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Product $product, User $user)
    {
        $this->product = $product;
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

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'product_id' => $this->product->id,
            'user_id' => $this->user->id,
            'product_label' => $this->product->label,
        ];
    }
}
