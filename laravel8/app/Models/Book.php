<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Publisher;

class Book extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'book_publisher_id', 'page_count', 'format', 'height', 'width', 'thickness', 'publication_date'];

    public function product(){
        return $this->belongsTo(Product::class);
    }
    
    public function publisher(){
        return $this->belongsTo(Publisher::class, 'book_publisher_id');
    }

    public function getPublisherAsLink(){
        $publisher = $this->publisher;
        return $publisher && $publisher->website ? '<a href="'.$publisher->website->url.'" class="link" target="_blank">'.$publisher->label.'</a>' : ($publisher ? $publisher->label : '');
    }
}
