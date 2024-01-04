@switch($kind)
    @case('success')
        @php($color = 'green')
        @php($icon = isset($icon) ? $icon : 'svg.check')
        @break
    @case('error')
        @php($color = 'red')
        @php($icon = isset($icon) ? $icon : 'svg.close')
        @break
    @case('warning')
        @php($color = 'orange')
        @php($icon = isset($icon) ? $icon : 'svg.warning')
        @break
    @case('info')
        @php($color = 'yellow')
        @php($icon = isset($icon) ? $icon : 'svg.info')
        @break
    @case('message')
        @php($color = 'blue')
        @php($icon = isset($icon) ? $icon : 'svg.msg')
        @break
@endswitch
<div id="notif_{{ $notif->id }}" class="w-full max-w-sm mx-auto overflow-hidden rounded shadow-sm">
    <x-notifs.head :notif="$notif" icon="{{ $icon }}" color="{{ $color }}" canClose="{{ (isset($canClose) || !isset($btn)) ? true : false }}">{{ $title }}</x-notifs.head>

    <div class="p-3 bg-white border border-gray-300 rounded-b">
        {{ $slot }}
    </div>
</div>