<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Listing;
use App\Models\User;

class ListingUser extends Model
{
    use HasFactory;
    protected $fillable = ['listing_id', 'user_id'];

    public function list(){
        return $this->belongsTo(Listing::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
