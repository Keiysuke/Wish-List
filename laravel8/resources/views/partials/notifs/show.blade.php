@if($notifs->isEmpty())
    <span class="px-2">Aucune notification</span>
@else
    @foreach($notifs as $notif)
        {!! \App\Services\NotificationService::renderNotif($notif) !!}
    @endforeach
@endif