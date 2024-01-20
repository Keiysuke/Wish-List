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
    
    public function section(){
        return $this->belongsTo(EmojiSection::class, 'emoji_section_id', 'id', 'emoji_section');
    }

    public static function findSpecific($kind = 'kbd_off'){
        switch ($kind) {
            case 'kbd_off': return self::find(1);
            case 'kbd_on': return self::find(15);
        }
    }
}
