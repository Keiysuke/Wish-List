<x-Notif :notif="$notif" kind="warning" title="Liste quittée par">
    <div class="flex flex-col content-center">
        <div class="flex justify-center gap-2 text-black">
            <x-svg.big.clipboard_list class="icon-sm"/><span class="font-semibold">{{ $notif->data['list_name'] }}</span>
        </div>
        <div class="friend-request-row text-black" data-id="{{ $notif->data['user_id'] }}">
            <div class="avatar">
                {{ ($notif->data['user_name'])[0] }}
            </div>
            <div class="name">
                {{ $notif->data['user_name'] }}
            </div>
        </div>
    </div>
</x-Notif>