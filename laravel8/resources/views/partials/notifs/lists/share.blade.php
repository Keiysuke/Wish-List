<x-Notif :notif="$notif" icon="svg.clipboard_list" kind="message" title="Vous avez rejoint une liste">
    <div class="flex flex-col content-center mb-2">
        <a href="{{ route('lists.index', ['id' => $notif->data['list_id']]) }}" class="link" target="_blank" onClick="deleteNotif('{{ $notif->id }}');">
            <div class="flex justify-center gap-2 text-black">
                <x-svg.big.clipboard_list class="icon-sm"/><span class="font-semibold">{{ $notif->data['list_name'] }}</span>
            </div>
        </a>
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