<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Selling;

class SellState extends Model
{
    use HasFactory;
    protected $fillable = ['label'];
    
    public function sellings(){
        return $this->hasMany(Selling::class);
    }
}
