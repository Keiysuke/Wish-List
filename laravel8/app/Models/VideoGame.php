<?php

namespace App\Models;

use App\Http\Controllers\UtilsController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\VgDeveloper;

class VideoGame extends Model
{
    use HasFactory;
    protected $fillable = ['vg_developer_id', 'label', 'date_released', 'nb_players'];

    public function vg_developer(){
        return $this->belongsTo(VgDeveloper::class);
    }

    public function date_released($format = 'd/m/Y'){
        return UtilsController::getDate($this->date_released, $format);
    }
}
