<?php

namespace App\Notifications\Lists\Products;

use App\Models\Listing;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\User;

class ProductEdited extends Notification
{
    use Queueable;

    protected $user;
    protected $list;
    protected $product;
    protected $old_nb;
    protected $nb;

    public function __construct(User $user, Listing $list, Product $product, int $old_nb, int $nb)
    {
        $this->user = $user;
        $this->list = $list;
        $this->product = $product;
        $this->old_nb = $old_nb;
        $this->nb = $nb;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        $this->product->setFirstPhoto();
        return [
            'user_id' => $this->user->id,
            'list_id' => $this->list->id,
            'list_name' => $this->list->label,
            'product_id' => $this->product->id,
            'product_name' => $this->product->label,
            'product_photo' => $this->product->pict,
            'old_nb' => $this->old_nb,
            'nb' => $this->nb,
        ];
    }
}
