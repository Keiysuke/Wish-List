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
    protected $fillable = ['developer_id', 'label', 'date_released', 'nb_players'];

    public function developer(){
        return $this->belongsTo(VgDeveloper::class);
    }

    public function products(){
        return $this->hasMany(ProductAsVideoGame::class);
    }

    public function vg_supports(){
        return $this->hasMany(ProductAsVideoGame::class);
    }

    public function date_released($format = 'd/m/Y'){
        return UtilsController::getDate($this->date_released, $format);
    }

    public function product(){
        $products = $this->products;
        return (count($products) > 0)? $products->first()->product : null;
    }
    
    public function support(){
        $products = $this->products;
        return (count($products) > 0)? $products->first()->support : null;
    }
}
