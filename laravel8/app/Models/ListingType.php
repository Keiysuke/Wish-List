<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Listing;

class ListingType extends Model
{
    use HasFactory;
    protected $fillable = ['label'];

    public function weapons(){
        return $this->hasMany(Listing::class);
    }
}
