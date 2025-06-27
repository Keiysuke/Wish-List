<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpotType extends Model
{
    use HasFactory;
    protected $fillable = ['label'];

    public function spots()
    {
        return $this->hasMany(Spot::class);
    }
}
