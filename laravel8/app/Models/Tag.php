<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\CssColor;

class Tag extends Model
{
    use HasFactory;
    protected $fillable = ['label', 'border_css_color_id', 'text_css_color_id', 'bg_css_color_id'];
    
    public function products(){
        return $this->belongsToMany(Product::class, 'product_tags')->withTimestamps();
    }

    public function border_css_color(){
        return $this->belongsTo(CssColor::class);
    }

    public function text_css_color(){
        return $this->belongsTo(CssColor::class);
    }

    public function bg_css_color(){
        return $this->belongsTo(CssColor::class);
    }
    
    public function css_color_details($kind){
        return $this->{$kind.'_css_color'}->class_details();
    }

    public function color($kind){
        return $this->{$kind.'_css_color'}->css_class;
    }

    public static function getExample($border_css_color_id = null, $text_css_color_id = null, $bg_css_color_id = null, $label = 'Exemple'){
        $tag = new Tag([
            'label' => $label,
            'border_css_color_id' => is_null($border_css_color_id)? 1 : $border_css_color_id,
            'text_css_color_id' => is_null($text_css_color_id)? 1 : $text_css_color_id,
            'bg_css_color_id' => is_null($bg_css_color_id)? 1 : $bg_css_color_id,
        ]);
        return $tag;
    }
}
