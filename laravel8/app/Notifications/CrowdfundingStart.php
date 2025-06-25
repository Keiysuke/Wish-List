<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Crowdfunding;
use App\Models\User;
use Carbon\Carbon;

class CrowdfundingStart extends Notification
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
        $days = Carbon::createFromFormat('Y-m-d', $this->crowdfunding->start_date)->diffInDays(Carbon::now());
        $this->crowdfunding->product->setFirstPhoto();
        return [
            'crowdfunding_id' => $this->crowdfunding->id,
            'project_name' => $this->crowdfunding->project_name,
            'product_id' => $this->crowdfunding->product_id,
            'product_photo' => $this->crowdfunding->product->pict,
            'user_id' => $this->user->id,
            'start_date' => $this->crowdfunding->start_date,
            'days' => $days,
        ];
    }
}
