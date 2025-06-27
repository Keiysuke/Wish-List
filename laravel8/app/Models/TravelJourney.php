<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelJourney extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'title'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function steps()
    {
        return $this->hasMany(TravelStep::class);
    }
}
