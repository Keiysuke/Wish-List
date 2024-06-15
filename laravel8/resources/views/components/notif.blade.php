@php($color = $kinds[$kind]['color'])
@php($icon = isset($icon) ? $icon : $kinds[$kind]['icon'])
<div id="notif{{ $notif->id }}">
    <x-Notifs.Head 
        :notif="$notif" 
        icon="{{ $icon }}" 
        color="{{ $color }}" 
        canClose="{{ (isset($canClose) || !isset($btn)) ? true : false }}"
        >
        {{ $title }}
    </x-Notifs.Head>

    <div class="p-3 bg-white border border-gray-300 rounded-b">
        {{ $slot }}
    </div>
</div>