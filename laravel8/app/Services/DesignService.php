<?php

namespace App\Services;

use App\Models\CssColor;

class DesignService
{
    const ANIM_ICONS = [
        'follow' => '💔',
        'unfollow' => '❤️',
    ];

    const ICONS = [
        'add_to_list' => ['sizes' => [true, false]],
        'archive' => ['sizes' => [true, true]],
        'arrow' => ['sizes' => [false, true]],
        'asc' => ['sizes' => [true, false]],
        'banked' => ['sizes' => [true, true]],
        'bell' => ['sizes' => [false, true]],
        'box' => ['sizes' => [false, true]],
        'book' => ['sizes' => [true, true]],
        'cart' => ['sizes' => [true, true]],
        'circle_search' => ['sizes' => [false, true]],
        'clock' => ['sizes' => [true, true]],
        'check' => ['sizes' => [true, true]],
        'chevron_d' => ['sizes' => [true, false]],
        'chevron_l' => ['sizes' => [true, false]],
        'christmas_tree' => ['sizes' => [true, true]],
        'circle_plus' => ['sizes' => [true, false]],
        'clipboard_list' => ['sizes' => [true, true]],
        'close' => ['sizes' => [true, false]],
        'cmd' => ['sizes' => [true, true]],
        'cog' => ['sizes' => [true, false]],
        'console' => ['sizes' => [true, true]],
        'db' => ['sizes' => [false, true]],
        'double_arrow' => ['sizes' => [false, true]],
        // 'duplicate' => ['sizes' => [true, true]],
        'desc' => ['sizes' => [true, false]],
        'edit' => ['sizes' => [true, false]],
        'euro' => ['sizes' => [true, true]],
        'excel' => ['sizes' => [true, false]],
        'extand' => ['sizes' => [false, true]],
        'external_link' => ['sizes' => [true, false]],
        'eye_close' => ['sizes' => [true, false]],
        'eye_open' => ['sizes' => [true, false]],
        'filter' => ['sizes' => [true, false]],
        'film' => ['sizes' => [true, true]],
        'folder' => ['sizes' => [true, false]],
        'gift' => ['sizes' => [true, true]],
        'globe' => ['sizes' => [true, true]],
        'globe_alt' => ['sizes' => [true, true]],
        'grid' => ['sizes' => [true, false]],
        'heart' => ['sizes' => [true, false]],
        'help' => ['sizes' => [true, true]],
        'house' => ['sizes' => [true, true]],
        'idea' => ['sizes' => [true, true]],
        'info' => ['sizes' => [true, true]],
        'like' => ['sizes' => [true, true]],
        'list' => ['sizes' => [true, false]],
        'log_out' => ['sizes' => [true, false]],
        'menu' => ['sizes' => [true, true]],
        'minus_circle' => ['sizes' => [true, false]],
        'moon' => ['sizes' => [false, true]],
        'mail' => ['sizes' => [false, true]],
        'map_pin' => ['sizes' => [true, true]],
        'music_note' => ['sizes' => [true, true]],
        'msg' => ['sizes' => [true, true]],
        'picture' => ['sizes' => [true, true]],
        'plus' => ['sizes' => [true, false]],
        'plus_circle' => ['sizes' => [true, false]],
        'profil' => ['sizes' => [false, true]],
        'puzzle' => ['sizes' => [true, true]],
        'refresh' => ['sizes' => [true, true]],
        'reply' => ['sizes' => [true, false]],
        'screen' => ['sizes' => [false, true]],
        'search' => ['sizes' => [true, false]],
        'send' => ['sizes' => [true, true]],
        'share' => ['sizes' => [true, true]],
        'shop_bag' => ['sizes' => [false, true]],
        'star' => ['sizes' => [true, true]],
        'stats' => ['sizes' => [false, true]],
        'sun' => ['sizes' => [false, true]],
        'template' => ['sizes' => [true, true]],
        'trophy' => ['sizes' => [false, true]],
        'trash' => ['sizes' => [true, false]],
        'truck' => ['sizes' => [true, true]],
        'user' => ['sizes' => [true, true]],
        'user_group' => ['sizes' => [true, true]],
        'users' => ['sizes' => [true, true]],
        'user_minus' => ['sizes' => [true, true]],
        'user_plus' => ['sizes' => [true, true]],
        'upper' => ['sizes' => [true, false]],
        'v_dot' => ['sizes' => [false, true]],
        'vg_controller' => ['sizes' => [false, true]],
        'warning' => ['sizes' => [true, true]],
        'zoom_in' => ['sizes' => [false, true]],
    ];

    /*
    * Return the list of SVG icons as their component name link
    */
    static function getIconsAsComponent($size = 'min') {
        $res = ['min' => [], 'big' => []];
        foreach (self::ICONS as $icon => $config) {
            if ($config['sizes'][0]) {
                $res['min'][$icon] = 'svg.' . $icon;
            }
            if ($config['sizes'][1]) {
                $res['big'][$icon] = 'svg.big.' . $icon;
            }
        }
        return $res;
    }

    static function getAnimIcon($kind) {
        return self::ANIM_ICONS[$kind];
    }
}
