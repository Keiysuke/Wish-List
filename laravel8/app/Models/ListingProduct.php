<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Listing;
use App\Models\Product;

class ListingProduct extends Model
{
    use HasFactory;
    protected $fillable = ['listing_id', 'product_id', 'nb'];

    public function list(){
        return $this->belongsTo(Listing::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
