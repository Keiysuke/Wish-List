<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Crowdfunding;
use App\Models\User;

class CrowdfundingShipped extends Notification
{
    use Queueable;

    protected $crowdfunding;
    protected $user;

    public function __construct(Crowdfunding $crowdfunding, User $user)
    {
        $this->crowdfunding = $crowdfunding;
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        $this->crowdfunding->product->setFirstPhoto();
        return [
            'crowdfunding_id' => $this->crowdfunding->id,
            'project_name' => $this->crowdfunding->project_name,
            'product_id' => $this->crowdfunding->product_id,
            'product_photo' => $this->crowdfunding->product->pict,
            'user_id' => $this->user->id,
            'shipping_date' => $this->crowdfunding->shipping_date,
        ];
    }
}
