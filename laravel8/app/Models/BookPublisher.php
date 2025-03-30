<?php

namespace App\Models;

use App\Http\Controllers\UtilsController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookPublisher extends Model
{
    use HasFactory;
    protected $fillable = ['label', 'description', 'founded_year', 'country', 'website_id', 'icon', 'active'];

    public function website(){
        return $this->belongsTo(Website::class);
    }

    public function books(){
        return $this->hasMany(Book::class);
    }

    public function description($length = 1000){
        return UtilsController::cutString($this->description, $length);
    }
}
