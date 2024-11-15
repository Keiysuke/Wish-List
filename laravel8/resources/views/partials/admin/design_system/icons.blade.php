<div class="wrap_h1">
    <h1>Liste des icônes SVG</h1>
    <x-svg.folder class="cursor icon-xs" title="Dossier des icônes SVG" onClick="setClipboard('{{ str_replace('\\', '/', 'E:\wamp\www\00 - API\products-managing\laravel8\resources\views\components\svg') }}')"/>
</div>

<x-admin.help.list_helpers>
    <a href="https://heroicons.com/outline" class="link" target="_blank">Heroicons</a>
    <a href="https://www.svgrepo.com/vectors/" class="link" target="_blank">SVG Repo</a>
    <a href="https://cdpn.io/shshaw/debug/XbxvNj" class="link" target="_blank">Pixels to SVG</a>
    DesignService::ICONS
</x-admin.help.list_helpers>

<h3 class="mt-0">1. Les petites icônes ({{ count($icons['min']) }})</h3>
<div class="grid grid-cols-10 gap-4">
    @foreach($icons['min'] as $icon)
        <div class="grid justify-items-center">
            <x-dynamic-component :component="$icon['component']" class="icon-sm" href="#"/>
            <span class="text-sm">{{ $icon['name'] }}</span>
        </div>
    @endforeach
</div>

<h3>2. Les grandes icônes ({{ count($icons['big']) }})</h3>
<div class="grid grid-cols-10 gap-4">
    @foreach($icons['big'] as $icon)
        <div class="grid justify-items-center">
            <x-dynamic-component :component="$icon['component']" class="icon-lg" href="#"/>
            <span class="text-sm">{{ $icon['name'] }}</span>
        </div>
    @endforeach
</div>

<h3>3. Les icônes sur le site</h3>

<div class="flex gap-1">
    <div id="show-video-game" class="title-icon inline-flex">
        <x-svg.big.vg_controller class="icon-xs"/>
    </div>
    <div class="title-icon inline-flex">
        <x-svg.edit class="icon-xs"/>
    </div>
    <div class="title-icon heart inline-flex" onclick="this.classList.toggle('on');">
        <x-svg.heart class="icon-xs"/>
    </div>
    <div class="title-icon archive inline-flex" onclick="this.classList.toggle('on');">
        <x-svg.archive class="icon-xs"/>
    </div>
    <div class="title-icon heart inline-flex">
        <x-svg.trash class="icon-xs"/>
    </div>
    <div class="title-icon refresh inline-flex">
        <x-svg.refresh class="icon-xs"/>
    </div>
    <x-Utils.Yt.TitleIcon search="Soundtrack"/>
    <x-Utils.Psthc.TitleIcon search="Lies of P" support="ps4"/>
    <x-products.search_photo search="#" class="title-icon inline-flex"/>
</div>

<h3>4. Les icônes animées<div class="ml-2 no-underline flex inline-flex">
        <x-Form.Checkbox class="mr-1" name="not"/>
        <x-Form.Label for="not">Effet inverse</x-Form.Label>
    </div>
</h3>
@php($elements = ['DesignService::ANIM_ICONS', 'riseIcon'])
<x-admin.help.list_helpers :elements="$elements"/>

<div class="flex gap-1">
    <div class="title-icon heart inline-flex" onclick="this.classList.toggle('on'); riseIcon(event, 'follow', !document.getElementById('not').checked);">
        <x-svg.heart class="icon-xs"/>
    </div>
</div>

<h3>4. Les emojis pour les messages</h3>
<x-admin.help.list_helpers>
    <a href="https://emojis.wiki/fr/" class="link" target="_blank">Emojis en texte</a>
    <a href="https://www.svgrepo.com/collection/yellow-emoji-icons/" class="link" target="_blank">Emojis SVG</a>
</x-admin.help.list_helpers>

A faire...
