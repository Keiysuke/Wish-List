<?php

namespace App\Services;

use App\Http\Controllers\UtilsController;

class SearchService
{
    CONST KINDS = [
        'yt' => [
            'link' => 'https://www.youtube.com/results?search_query=', 
            'replace' => [
                "&amp;" => '%26',
                "&#039;" => '%27',
                ' ' => '+',
            ]
        ],
        'psthc' => [
            'link' => 'https://www.psthc.fr/unjeu/', 
            'after' => '/guide-trophees.htm', 
            'replace' => [
                ' ' => '-', 
                "&#039;s" => '', 
                ':' => '',
                'of ' => '',
            ]
        ],
        'offer' => [
            'link' => 'https://ledenicheur.fr/search?search=', 
            'replace' => [
                ' ' => '%20',
                "&#039;" => '%27',
                "#" => '%23',
            ]
        ],
        'bookhunt' => [
            'link' => 'https://www.chasse-aux-livres.fr/search?catalog=fr&query=', 
            'replace' => [
                ' ' => '+',
                "&#039;" => '%27',
                "#" => '%23',
            ]
        ],
        'booknode' => [
            'link' => 'https://booknode.com/search?q=', 
            'replace' => [
                ' ' => '+', 
                ':' => '%3A',
                "&#039;" => '%27',
                "#" => '%23',
            ]
        ],
        'pictures' => [
            'link' => 'https://www.google.com/search?q=', 
            'after' => '&sca_esv=4ce04de13f7e18f6&sca_upv=1&rlz=1C1CHBF_frFR906FR906&udm=2&biw=1920&bih=919&sxsrf=ADLYWILvwrDl4z_fWxSF3uhbyxGNWIO59Q%3A1717787401594&ei=CVtjZo7uI8itkdUP5aO4wA4&ved=0ahUKEwjOlvzemMqGAxXIVqQEHeURDugQ4dUDCBA&uact=5&oq=The+Essential+Games+Music+Collection&gs_lp=Egxnd3Mtd2l6LXNlcnAiJFRoZSBFc3NlbnRpYWwgR2FtZXMgTXVzaWMgQ29sbGVjdGlvbjIHEAAYgAQYGEjWBlAAWABwAXgAkAEAmAEAoAEAqgEAuAEDyAEAmAIBoAICmAMAiAYBkgcBMaAHAA&sclient=gws-wiz-serp', 
            'replace' => [' ' => '+']
        ],
    ];
    public static function getLink(string $kind, string $search){
        if ($kind === 'psthc') return self::psthc($search);
        $kind = self::KINDS[$kind];
        return $kind['link'].strtr($search, $kind['replace']).($kind['after'] ?? '');
    }

    public static function psthc($search, $support = 'ps4') {
        $search = strtolower(strtr($search, self::KINDS['psthc']['replace']));
        $s = '';
        foreach(explode('-', $search) as $term){
            if(!strcmp($term, intval($term))) $s .= $term;
            else $s .= $term.'-';
        }
        return 'https://www.psthc.fr/unjeu/' . $s . strtolower($support).self::KINDS['psthc']['after'];
    }
}
