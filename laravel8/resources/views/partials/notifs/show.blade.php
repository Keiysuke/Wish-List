@if($notifs->isEmpty())
    <span class="px-2">Aucune notification</span>
@else
    @foreach($notifs as $notif)
        @if(in_array($notif->type, ['App\Notifications\ProductSoonAvailable', 'App\Notifications\ProductSoonExpire']))
            @include("partials.notifs.products.soon", $notif)
        @elseif(in_array($notif->type, ['App\Notifications\FriendRequest']))
            @include("partials.notifs.requests.friend", $notif)
        @elseif(in_array($notif->type, ['App\Notifications\ShareList']))
            @include("partials.notifs.lists.share", $notif)
        @elseif(in_array($notif->type, ['App\Notifications\ListLeft']))
            @include("partials.notifs.lists.left", $notif)
        @endif
    @endforeach
@endif