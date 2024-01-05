@php($color = $kinds[$kind]['color'])
@php($icon = isset($icon) ? $icon : $kinds[$kind]['icon'])
<div id="notif_{{ $notif->id }}" class="w-full max-w-sm mx-auto overflow-hidden rounded shadow-sm">
    <x-notifs.head :notif="$notif" icon="{{ $icon }}" color="{{ $color }}" canClose="{{ (isset($canClose) || !isset($btn)) ? true : false }}">{{ $title }}</x-notifs.head>

    <div class="p-3 bg-white border border-gray-300 rounded-b">
        {{ $slot }}
    </div>
</div>