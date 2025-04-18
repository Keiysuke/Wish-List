<?php

namespace App\Models;

use App\Http\Controllers\UtilsController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VgDeveloper extends Model
{
    use HasFactory;
    protected $fillable = ['label', 'description', 'creator', 'year_created'];

    public function description($length = 1000){
        return UtilsController::cutString($this->description, $length);
    }
}
