<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Website;
use App\Models\UserWebsiteSection;

class UserWebsite extends Model{
    use HasFactory;
    protected $fillable = ['user_id', 'website_id', 'user_website_section_id', 'ordered', 'custom_url'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function website(){
        return $this->belongsTo(Website::class);
    }

    public function user_website_section(){
        return $this->belongsTo(UserWebsiteSection::class);
    }
}
