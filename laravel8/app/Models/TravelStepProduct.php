<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelStepProduct extends Model
{
    use HasFactory;
    protected $fillable = ['travel_step_id', 'product_id', 'purchase_id', 'group_buy_id', 'notes'];

    public function travel_step()
    {
        return $this->belongsTo(TravelStep::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function group_buy()
    {
        return $this->belongsTo(GroupBuy::class);
    }
}
