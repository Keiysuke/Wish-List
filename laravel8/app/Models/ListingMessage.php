<?php
namespace App\Models;

use App\Http\Controllers\UtilsController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Listing;
use App\Models\User;
use App\Services\ReactionService;

class ListingMessage extends Model
{
    use HasFactory;
    public $allReactions = [];
    protected $fillable = ['listing_id', 'user_id', 'message', 'answer_to_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    
    public function list(){
        return $this->belongsTo(Listing::class);
    }

    public function answer_to(){
        return $this->belongsTo(ListingMessage::class);
    }

    public function reactions(){
        return $this->hasMany(ListMsgReaction::class, 'list_msg_id', 'id');
    }
    
    public function yours(){
        return $this->user_id === auth()->user()->id;
    }
    
    public function replyingToMsg($siz = 30){
        return UtilsController::cutString($this->message, $siz);
    }

    public function setReactions(){
        $this->allReactions = (new ReactionService($this))->getReactions();
        foreach($this->allReactions as $rea) {
            var_dump($rea);
        }
    }
}
