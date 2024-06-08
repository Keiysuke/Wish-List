<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\ProductWebsite;
use App\Models\User;
use Carbon\Carbon;

class ProductSoonAvailable extends Notification
{
    use Queueable;

    protected $user;
    protected $productWebsite;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ProductWebsite $productWebsite, User $user)
    {
        $this->productWebsite = $productWebsite;
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
        $days = Carbon::createFromFormat('Y-m-d H:i:s', $this->productWebsite->available_date)->diffInDays(Carbon::now());
        $this->productWebsite->product->setFirstPhoto();
        return [
            'product_label' => $this->productWebsite->product->label,
            'days' => $days,
            'available_date' => $this->productWebsite->available_date,
            'product_photo' => $this->productWebsite->product->pict,
            'product_id' => $this->productWebsite->product_id,
            'product_website_id' => $this->productWebsite->id,
            'user_id' => $this->user->id,
        ];
    }
}
