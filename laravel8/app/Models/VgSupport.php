<?php

namespace App\Models;

use App\Services\DateService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VgSupport extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'label', 'alias', 'date_released', 'price'];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function with_alias(){
        return $this->label.' ('.$this->alias.')';
    }

    public function date_released($format = 'd/m/Y'){
        return DateService::getDate($this->date_released, $format);
    }

    public function isPsn(){
        return in_array($this->alias, ['PS1', 'PS2', 'PS3', 'PS4', 'PS5']);
    }
}
