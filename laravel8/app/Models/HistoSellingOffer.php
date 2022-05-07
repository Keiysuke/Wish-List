<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Selling;

class HistoSellingOffer extends Model
{
    use HasFactory;
    protected $fillable = ['selling_id', 'price', 'day'];

    public function selling(){
        return $this->hasOne(Selling::class);
    }
}
