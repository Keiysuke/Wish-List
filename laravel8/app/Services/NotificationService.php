<?php

namespace App\Services;

class NotificationService
{
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
        'custom' => [
            'id' => 'notif_6', 
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
}
