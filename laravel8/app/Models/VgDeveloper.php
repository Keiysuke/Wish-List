<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VgDeveloper extends Model
{
    use HasFactory;
    protected $fillable = ['label', 'description', 'creator', 'year_created'];

    public function description($length = 1000){
        $longer = strlen($this->description) > $length;
        return substr($this->description, 0, $length) . (($longer)? '...' : '');
    }
}
