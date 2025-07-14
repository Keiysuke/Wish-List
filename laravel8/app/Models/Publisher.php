<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    use HasFactory;
    protected $fillable = [
        'label', 'description', 'founded_year', 'city_id', 'website_id', 'icon', 'active', 'type_id'
    ];

    public function website(){
        return $this->belongsTo(Website::class);
    }

    public function city(){
        return $this->belongsTo(City::class);
    }

    public function type(){
        return $this->belongsTo(PublisherType::class, 'type_id');
    }
}
