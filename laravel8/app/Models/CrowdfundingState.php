<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrowdfundingState extends Model
{
    use HasFactory;
    protected $fillable = ['label'];
    const STARTED = 2;
    const BANKED = 3;
    const SENDING = 4;
    const DONE = 5;

    public function crowdfundings(){
        return $this->hasMany(Crowdfunding::class);
    }
}
