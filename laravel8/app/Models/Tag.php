<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\CssColor;

class Tag extends Model
{
    use HasFactory;
    protected $fillable = ['label', 'css_color_id'];
    
    public function products(){
        return $this->belongsToMany(Product::class, 'product_tags')->withTimestamps();
    }

    public function css_color(){
        return $this->belongsTo(CssColor::class);
    }
    
    public function border_details(){
        return $this->css_color->class_details();
    }

    public function color(){
        return $this->css_color->css_class;
    }

    public static function getExample($css_color_id = null, $label = 'Exemple'){
        $tag = new Tag([
            'label' => $label,
            'css_color_id' => is_null($css_color_id)? 1 : $css_color_id,
        ]);
        return $tag;
    }
}
