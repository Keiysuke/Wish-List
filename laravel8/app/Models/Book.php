<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\BookPublisher;

class Book extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'book_publisher_id', 'page_count', 'format', 'height', 'width', 'thickness', 'publication_date'];

    public function product(){
        return $this->belongsTo(Product::class);
    }
    
    public function publisher(){
        return $this->belongsTo(BookPublisher::class, 'book_publisher_id');
    }
}
