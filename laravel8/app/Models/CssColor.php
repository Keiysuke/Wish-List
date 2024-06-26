<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tag;

class CssColor extends Model
{
    use HasFactory;
    protected $fillable = ['css_class', 'hexadecimal'];
    
    public function tags(){
        return $this->hasMany(Tag::class);
    }

    public static function uniqueColors(){
        $found = [];
        foreach(self::all() as $color){
            $color = explode('-', $color->css_class);
            $color = is_array($color)? $color[0] : $color;
            if(!in_array($color, $found)) $found[] = $color;
        }
        return $found;
    }

    public function color_variants($color){
        return $this::where('css_class', 'like', $color.'%')->get();
    }

    public function class_details(){
        $details = explode('-', $this->css_class);
        return (Object)['color' => $details[0], 'variant' => $details[1] ?? 'none'];
    }

    public static function has_variants($color) {
        return !in_array($color, ['black', 'white']);
    }
}
