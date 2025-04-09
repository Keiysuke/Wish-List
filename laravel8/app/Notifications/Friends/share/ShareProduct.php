<?php

namespace App\Notifications\Friends\Share;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\User;

class ShareProduct extends Notification
{
    use Queueable;

    protected $user;
    protected $product;

    public function __construct(User $user, Product $product)
    {
        $this->user = $user;
        $this->product = $product;
        $this->product->setFirstPhoto();
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
            'product_id' => $this->product->id,
            'product_label' => $this->product->label,
            'product_photo' => $this->product->pict,
        ];
    }
}
