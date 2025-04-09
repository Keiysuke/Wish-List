<?php

namespace App\Services;

class NotificationService
{
    const NOTIFS = [
        'default' => [
            'kind' => 'success',
            'title' => 'Titre manquant',
        ],
        'App\Notifications\ProductSoonAvailable' => [
            'url' => 'products.soon',
        ],
        'App\Notifications\ProductSoonExpire' => [
            'url' => 'products.soon',
        ],
        'App\Notifications\MissingPhotos' => [
            'url' => 'products.no_photos',
        ],
        'App\Notifications\MissingProductOnVideoGame' => [
            'url' => 'video_games.no_product',
        ],
        'App\Notifications\FriendRequest' => [
            'url' => 'requests.friend',
        ],
        'App\Notifications\Lists\ShareList' => [
            'url' => 'lists.share',
        ],
        'App\Notifications\Friends\Share\ShareProduct' => [
            'url' => 'products.share',
        ],
        'App\Notifications\Lists\ListLeft' => [
            'url' => 'lists.left',
        ],
        'App\Notifications\Lists\Products\ProductEdited' => [
            'url' => 'lists.products.modified',
            'kind' => 'warning',
            'title' => 'Produit de liste édité',
            'custom' => [
                'edited' => true,
            ],
        ],
        'App\Notifications\Lists\Products\ProductAdded' => [
            'url' => 'lists.products.modified',
            'title' => 'Produit de liste ajouté',
        ],
        'App\Notifications\Lists\Products\ProductRemoved' => [
            'url' => 'lists.products.modified',
            'kind' => 'error',
            'title' => 'Produit de liste retiré',
        ],
    ];

    const KINDS = [
        'success' => [
            'id' => 'notif_1', 
            'color' => 'green', 
            'icon' => 'svg.check', 
            'title' => 'Messages positifs'
        ], 
        'error' => [
            'id' => 'notif_2', 
            'color' => 'red', 
            'icon' => 'svg.close', 
            'title' => 'Messages négatifs'
        ], 
        'warning' => [
            'id' => 'notif_3', 
            'color' => 'orange', 
            'icon' => 'svg.warning', 
            'title' => 'Messages risqués'
        ], 
        'info' => [
            'id' => 'notif_4', 
            'color' => 'yellow', 
            'icon' => 'svg.info', 
            'title' => 'Informations diverses'
        ], 
        'message' => [
            'id' => 'notif_5', 
            'color' => 'blue', 
            'icon' => 'svg.msg', 
            'title' => 'Intéraction entre utilisateurs'
        ], 
        'share' => [
            'id' => 'notif_6', 
            'color' => 'pink', 
            'icon' => 'svg.share', 
            'title' => 'Partage entre utilisateurs'
        ], 
        'custom' => [
            'id' => 'notif_7', 
            'color' => 'pink', 
            'icon' => 'svg.heart', 
            'title' => 'Customisez comme vous le souhaitez !'
        ], 
    ];

    static function getExistingNotifications() {
        $notifs = [];
        foreach (self::KINDS as $kind => $d) {
            $notifs[$kind] = self::getExample($kind);
        }
        return $notifs;
    }

    static function getExample($kind) {
        return (Object)self::KINDS[$kind];
    }

    static function getUrl($notif) {
        return 'partials.notifs.'.$notif['url'];
    }

    static function renderNotif($notif) {
        $details = self::NOTIFS[$notif->type];
        foreach (['kind', 'title'] as $key) {
            $notif->$key = $details[$key] ?? self::NOTIFS['default'][$key];
        }
        self::getCustomProps($details, $notif);
        return view(self::getUrl($details))->with(compact('notif'))->render();
    }

    static function getCustomProps($config, &$notif) {
        if (isset($config['custom'])) {
            foreach ($config['custom'] as $key => $value) {
                $notif->$key = $value;
            }
        }
    }

    static function getModel($type) {
        $r = null;
        switch ($type) {
            case 'list': $r = 'App\Models\Listing';
                break;
            case 'product': $r = 'App\Models\Product';
                break;
        }
        return $r;
    }
}
