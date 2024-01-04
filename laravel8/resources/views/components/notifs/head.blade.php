<div class="relative flex items-center justify-between px-2 py-2 font-bold text-white bg-{{ $color }}-500">
    <div class="relative flex items-center gap-2">
        <x-dynamic-component :component="$icon" class="icon-sm"/>
        <span>{{ $slot }}</span>
    </div>
    @if($canClose)
    <x-svg.close wStroke="3" class="no-propagate icon-xs cursor-pointer text-{{ $color }}-300 fill-current hover:text-white" title="Supprimer" onClick="deleteNotif('{{ $notif->id }}');"/>
    @endif
</div>