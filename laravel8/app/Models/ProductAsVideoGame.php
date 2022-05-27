<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\VideoGame;
use App\Models\VgSupport;

class ProductAsVideoGame extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'video_game_id', 'vg_support_id'];

    public function product(){
        return $this->belongsTo(Product::class);
    }
    
    public function video_game(){
        return $this->belongsTo(VideoGame::class);
    }
    
    public function vg_support(){
        return $this->belongsTo(VgSupport::class);
    }
}
