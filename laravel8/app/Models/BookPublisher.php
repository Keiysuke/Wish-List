<?php

namespace App\Models;

use App\Http\Controllers\UtilsController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookPublisher extends Model
{
    use HasFactory;
    protected $fillable = ['label', 'description', 'founded_year', 'country', 'website_id', 'icon', 'active'];

    public function website(){
        return $this->belongsTo(Website::class);
    }

    public function books(){
        return $this->hasMany(Book::class);
    }
    
    public function description($length = 1000){
        return UtilsController::cutString($this->description, $length);
    }

    public function fast_link_product(): int{
        $offers = ProductWebsite::with('product')->where('website_id', '=', $this->website_id)->get();
        
        $nb = 0;
        foreach($offers as $offer) {
            $product = $offer->product;
            if ($product->noTemplate()) {
                Book::create([
                    'book_publisher_id' => $this->id,
                    'product_id' => $product->id,
                ]);
                $nb++;
            }
        }
        return $nb;
    }
}
