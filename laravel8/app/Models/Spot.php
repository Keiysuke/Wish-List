<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spot extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'city_id', 'type'];

    public function city()
    {
        return $this->belongsTo(City::class);
    }
    
    public function spotType()
    {
        return $this->belongsTo(SpotType::class);
    }
}
