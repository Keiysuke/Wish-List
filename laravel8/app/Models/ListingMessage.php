<?php
namespace App\Models;

use App\Http\Controllers\UtilsController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Listing;
use App\Models\User;

class ListingMessage extends Model
{
    use HasFactory;
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

    public function yours(){
        return $this->user_id === auth()->user()->id;
    }

    public function replyingToMsg($siz = 30){
        return UtilsController::cutString($this->message, $siz);
    }
}
