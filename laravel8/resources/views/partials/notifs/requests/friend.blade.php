<x-Notif 
    :notif="$notif" 
    icon="svg.user" 
    kind="message" 
    title="{{ __('Friend request') }}"
    >
    <div class="friend-request-row text-black" data-id="{{ $notif->data['user_id'] }}">
        <div class="avatar">
            {{ ($notif->data['user_name'])[0] }}
        </div>
        <div class="name">
            {{ $notif->data['user_name'] }}
        </div>
    </div>
    <div class="flex justify-center w-full text-xs gap-4">
        <x-Notifs.Btn 
            data-user-id="{{ $notif->data['user_id'] }}" 
            data-friend-id="{{ $notif->data['friend_id'] }}" 
            data-answer="refuse" 
            class="friend-request" 
            title="Refuser la demande d'ami"
            >
            Refuser
        </x-Notifs.Btn>
        <x-Notifs.Btn 
            important color="blue" 
            data-user-id="{{ $notif->data['user_id'] }}" 
            data-friend-id="{{ $notif->data['friend_id'] }}" 
            data-answer="accept" 
            class="friend-request" 
            title="Accepter la demande d'ami">
            Accepter
        </x-Notifs.Btn>
    </div>
</x-Notif>