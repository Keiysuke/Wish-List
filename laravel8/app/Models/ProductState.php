<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Purchase;
use App\Models\Selling;

class ProductState extends Model
{
    use HasFactory;
    protected $fillable = ['label'];

    public function purchases(){
        return $this->hasMany(Purchase::class);
    }
    
    public function sellings(){
        return $this->hasMany(Selling::class);
    }
}
