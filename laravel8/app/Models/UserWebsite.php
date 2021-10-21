<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Website;

class GroupBuyPurchase extends Model{
    use HasFactory;
    protected $fillable = ['user_id', 'website_id', 'favorite_order'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function website(){
        return $this->belongsTo(Website::class);
    }
}
