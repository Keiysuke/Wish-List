<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelStep extends Model
{
    use HasFactory;
    protected $fillable = ['travel_journey_id', 'city_id', 'start_date', 'end_date'];

    public function journey()
    {
        return $this->belongsTo(TravelJourney::class, 'travel_journey_id');
    }
    
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
