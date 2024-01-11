<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Emoji;

class EmojiSection extends Model
{
    use HasFactory;
    protected $fillable = ['label'];
    
    public function emojis(){
        return $this->hasMany(Emoji::class);
    }
}
