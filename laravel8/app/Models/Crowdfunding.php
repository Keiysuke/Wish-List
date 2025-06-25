<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crowdfunding extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'website_id', 'project_name', 'project_url', 'goal_amount', 'current_amount', 'start_date', 'end_date', 'shipping_date', 'state_id'];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function website(){
        return $this->belongsTo(Website::class);
    }
    
    public function state(){
        return $this->belongsTo(CrowdfundingState::class);
    }

    public function inState($state_id){
        return $this->state_id == $state_id;
    }

    public function banked(){
        return $this->inState(CrowdfundingState::BANKED) && $this->end_date <= now();
    }

    public function sending(){
        return $this->inState(CrowdfundingState::SENDING) || !is_null($this->shipping_date);
    }

    public function done(){
        return $this->inState(CrowdfundingState::DONE) && $this->shipping_date && $this->shipping_date <= now();
    }
}
