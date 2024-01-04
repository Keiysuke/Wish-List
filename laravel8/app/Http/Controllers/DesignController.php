<?php

namespace App\Http\Controllers;

class DesignController extends Controller
{
    const ICONS = [
        ['name' => 'add_to_list', 'sizes' => [true, false]],
        ['name' => 'archive', 'sizes' => [true, true]],
        ['name' => 'arrow', 'sizes' => [false, true]],
        ['name' => 'asc', 'sizes' => [true, false]],
        ['name' => 'bell', 'sizes' => [false, true]],
        ['name' => 'cart', 'sizes' => [true, true]],
        ['name' => 'circle_search', 'sizes' => [false, true]],
        ['name' => 'clock', 'sizes' => [true, true]],
        ['name' => 'check', 'sizes' => [true, false]],
        ['name' => 'chevron_d', 'sizes' => [true, false]],
        ['name' => 'chevron_l', 'sizes' => [true, false]],
        ['name' => 'christmas_tree', 'sizes' => [true, true]],
        ['name' => 'circle_plus', 'sizes' => [true, false]],
        ['name' => 'clipboard_list', 'sizes' => [true, true]],
        ['name' => 'close', 'sizes' => [true, false]],
        ['name' => 'cog', 'sizes' => [true, false]],
        ['name' => 'db', 'sizes' => [false, true]],
        ['name' => 'double_arrow', 'sizes' => [false, true]],
        ['name' => 'desc', 'sizes' => [true, false]],
        ['name' => 'edit', 'sizes' => [true, false]],
        ['name' => 'euro', 'sizes' => [true, true]],
        ['name' => 'excel', 'sizes' => [true, false]],
        ['name' => 'external_link', 'sizes' => [true, false]],
        ['name' => 'eye_close', 'sizes' => [true, false]],
        ['name' => 'eye_open', 'sizes' => [true, false]],
        ['name' => 'filter', 'sizes' => [true, false]],
        ['name' => 'folder', 'sizes' => [true, false]],
        ['name' => 'gift', 'sizes' => [true, true]],
        ['name' => 'globe', 'sizes' => [true, true]],
        ['name' => 'globe_alt', 'sizes' => [true, true]],
        ['name' => 'grid', 'sizes' => [true, false]],
        ['name' => 'heart', 'sizes' => [true, false]],
        ['name' => 'help', 'sizes' => [true, true]],
        ['name' => 'house', 'sizes' => [true, true]],
        ['name' => 'info', 'sizes' => [true, true]],
        ['name' => 'list', 'sizes' => [true, false]],
        ['name' => 'log_out', 'sizes' => [true, false]],
        ['name' => 'menu', 'sizes' => [true, true]],
        ['name' => 'minus_circle', 'sizes' => [true, false]],
        ['name' => 'moon', 'sizes' => [false, true]],
        ['name' => 'mail', 'sizes' => [false, true]],
        ['name' => 'music_note', 'sizes' => [true, true]],
        ['name' => 'msg', 'sizes' => [true, true]],
        ['name' => 'picture', 'sizes' => [true, true]],
        ['name' => 'plus', 'sizes' => [true, false]],
        ['name' => 'plus_circle', 'sizes' => [true, false]],
        ['name' => 'profil', 'sizes' => [false, true]],
        ['name' => 'refresh', 'sizes' => [true, true]],
        ['name' => 'reply', 'sizes' => [true, false]],
        ['name' => 'screen', 'sizes' => [false, true]],
        ['name' => 'search', 'sizes' => [true, false]],
        ['name' => 'share', 'sizes' => [true, true]],
        ['name' => 'shop_bag', 'sizes' => [false, true]],
        ['name' => 'star', 'sizes' => [true, true]],
        ['name' => 'stats', 'sizes' => [false, true]],
        ['name' => 'sun', 'sizes' => [false, true]],
        ['name' => 'template', 'sizes' => [true, true]],
        ['name' => 'trophy', 'sizes' => [false, true]],
        ['name' => 'trash', 'sizes' => [true, false]],
        ['name' => 'truck', 'sizes' => [true, true]],
        ['name' => 'user', 'sizes' => [true, true]],
        ['name' => 'user_group', 'sizes' => [true, true]],
        ['name' => 'users', 'sizes' => [true, true]],
        ['name' => 'user_minus', 'sizes' => [true, true]],
        ['name' => 'user_plus', 'sizes' => [true, true]],
        ['name' => 'upper', 'sizes' => [true, false]],
        ['name' => 'vg_controller', 'sizes' => [false, true]],
        ['name' => 'warning', 'sizes' => [true, true]],
        ['name' => 'zoom_in', 'sizes' => [false, true]],
    ];

    /*
    * Return the list of SVG icons
    */
    static function getIcons($size = 'min') {
        $res = [];
        foreach (self::ICONS as $icon) {
            if ($icon['sizes'][$size === 'big']) $res[] = $icon['name'];
        }
        return $res;
    }

    /*
    * Return the list of SVG icons as their component name link
    */
    static function getIconsAsComponent($size = 'min') {
        $res = [];
        foreach (self::getIcons($size) as $icon) {
            $res[] = [
                'name' => $icon,
                'component' => 'svg.'.($size === 'big' ? 'big.' : '').$icon,
            ];
        }
        return $res;
    }
}
