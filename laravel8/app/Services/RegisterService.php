<?php

namespace App\Services;

use App\Http\Controllers\ListingController;
use App\Http\Requests\ListingRequest;

class RegisterService
{
    /**
     * Creates some lists for new users
    */
    public static function justCreated(int $user_id) {
        $listingController = new ListingController();
        $request = new ListingRequest([
            'user_id' => $user_id,
            'listing_type_id' => 1,
            'label' => 'Envies',
            'description' => 'Liste par défaut',
            'secret' => 0,
        ]);
        $listingController->store($request);
        
        $request = new ListingRequest([
            'user_id' => $user_id,
            'listing_type_id' => 1,
            'label' => 'Noël',
            'description' => 'Liste secrète par défaut',
            'secret' => 1,
        ]);
        $listingController->store($request);

        $request = new ListingRequest([
            'user_id' => $user_id,
            'listing_type_id' => 2,
            'label' => 'Mes jeux vidéo',
            'description' => 'Liste par défaut de type Jeux Vidéo',
            'secret' => 0,
        ]);
        $listingController->store($request);
    }
}
