@php($ok = $notif->data['status'])
<x-notif :notif="$notif" kind="{{ $ok ? 'success' : 'error' }}" title="{{ $ok ? 'Liste rejointe' : 'Liste non rejointe' }}">
    <div class="flex flex-col content-center">
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
</x-notif>