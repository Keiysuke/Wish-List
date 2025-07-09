<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelJourney extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'label'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function travelSteps()
    {
        return $this->hasMany(TravelStep::class);
    }
}
