<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Selling;

class SellState extends Model
{
    use HasFactory;
    protected $fillable = ['label'];
    const CLOSED = 5;
    
    public function sellings(){
        return $this->hasMany(Selling::class);
    }
}
