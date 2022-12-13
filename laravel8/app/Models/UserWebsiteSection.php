<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserWebsite;

class UserWebsiteSection extends Model
{
    use HasFactory;
    protected $fillable = ['label', 'icon', 'bg_css_color_id'];
    
    public function user_websites(){
        return $this->hasMany(UserWebsite::class);
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
}
