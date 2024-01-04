<x-notif :notif="$notif" icon="svg.clipboard_list" kind="message" title="Rejoindre la liste ?">
    <div class="flex flex-col content-center mb-2">
        <div class="friend_request_row text-black" data-id="{{ $notif->data['user_id'] }}">
            <div class="avatar">
                {{ ($notif->data['user_name'])[0] }}
            </div>
            <div class="name">
                {{ $notif->data['user_name'] }}
            </div>
        </div>
        <div class="flex justify-center gap-2 text-black">
            <x-svg.big.clipboard_list class="icon-sm"/><span class="font-semibold">{{ $notif->data['list_name'] }}</span>
        </div>
    </div>
    <div class="flex justify-center w-full text-xs gap-4">
        <x-notifs.btn data-user-id="{{ $notif->data['user_id'] }}" data-list-id="{{ $notif->data['list_id'] }}" class="unjoin_friend_list" title="Refuser l'invitation">
            Refuser
        </x-notifs.btn>
        <x-notifs.btn important color="blue" data-user-id="{{ $notif->data['user_id'] }}" data-list-id="{{ $notif->data['list_id'] }}" class="join_friend_list" title="Accepter l'invitation">
            Accepter
        </x-notifs.btn>
    </div>
</x-notif>