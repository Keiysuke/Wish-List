<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EmojiSection;

class Emoji extends Model
{
    protected $table = 'emojis';
    use HasFactory;
    protected $fillable = ['label', 'emoji_section_id'];
    
    public function emoji_section(){
        return $this->belongsTo(EmojiSection::class);
    }
}
