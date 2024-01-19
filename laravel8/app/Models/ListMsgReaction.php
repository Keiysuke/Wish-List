<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListMsgReaction extends Model
{
    use HasFactory;
    protected $fillable = ['list_msg_id', 'emoji_id', 'user_id'];
    
    public function message(){
        return $this->belongsTo(ListingMessage::class);
    }

    public function emoji(){
        return $this->belongsTo(Emoji::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
