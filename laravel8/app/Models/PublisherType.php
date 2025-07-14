<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublisherType extends Model
{
    use HasFactory;
    protected $fillable = ['label', 'description'];

    public const BOOK = 1;
    public const ANIME = 2;
    public const BOARDGAME = 3;

    public const TYPE_LABELS = [
        'book' => 'Maison d\'édition de livres',
        'anime' => 'Studio d\'animation',
        'boardgame' => 'Maison d\'édition de jeux de société',
    ];

    public function publishers()
    {
        return $this->hasMany(Publisher::class, 'type_id');
    }

    public function getName()
    {
        return self::TYPE_LABELS[$this->label];
    }
}
