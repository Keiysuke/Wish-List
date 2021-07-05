<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\GroupBuy;
use App\Models\Purchase;

class GroupBuyPurchase extends Model{
    use HasFactory;
    protected $fillable = ['group_buy_id', 'purchase_id'];

    public function group_buy(){
        return $this->belongsTo(GroupBuy::class);
    }

    public function purchase(){
        return $this->belongsTo(Purchase::class);
    }
}
