<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'postal_code', 'country_id'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function spots()
    {
        return $this->hasMany(Spot::class);
    }

    public function publishers()
    {
        return $this->hasMany(Publisher::class);
    }
}
