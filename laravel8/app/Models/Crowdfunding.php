<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crowdfunding extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'website_id', 'project_name', 'project_url', 'goal_amount', 'current_amount', 'start_date', 'end_date', 'shipping_date', 'status'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function website()
    {
        return $this->belongsTo(Website::class);
    }
    
    public function state()
    {
        return $this->belongsTo(CrowdfundingState::class, 'status');
    }
}
