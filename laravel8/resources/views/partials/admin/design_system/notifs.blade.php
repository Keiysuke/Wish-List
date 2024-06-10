<div class="wrap_h1 mt-8">
    <h1>Liste des notifications</h1>
    <x-svg.big.bell class="icon-lg"/>
</div>

<h3>1. Les notifications de formulaire</h3>
@php($elements = ['x-Notification'])
<x-admin.help.list_helpers :elements="$elements"/>

<div class="grid grid-cols-2 gap-4">
    <x-Notification type="success" msg="Exemple de message d'action réussie" example/>
    <x-Notification type="error" msg="Exemple de message d'action echouée" example/>
</div>

<h3>2. Les notifications en attente</h3>
@php($elements = ['App/Notifications', 'NotificationsController', 'NotificationService', 'x-Notif'])
<x-admin.help.list_helpers :elements="$elements"/>

<div class="grid grid-cols-3 gap-4">
    @foreach($notifications as $kind => $notif)
        <div class="grid justify-items-center">
            <x-Notif :notif="$notif" kind="{{ $kind }}" title="{{ $notif->title }}">
                Vous pouvez insérer tout type de contenu ici
            </x-Notif>
        </div>
    @endforeach
</div>

<x-Window.Coding class="mt-4 w-10/12" title="Supprimer une notification d'un utilisateur" major="auth()->user() | ->notifications() | ->whereJsonContains">
    auth()->user()->notifications()->where('type', '=', 'App\Notifications\FriendRequest')<br />
        ->whereJsonContains('data->user_id', $userId)<br />
        ->first()<br />
        ->delete();<br />
</x-Window.Coding >

<h3>3. Les notifications dynamiques</h3>
@php($elements = ['my_notyf.js', 'Notyf'])
<x-admin.help.list_helpers :elements="$elements"/>

<div class="flex flex-wrap justify-center gap-4">
    <x-Form.Input name="notyf_text" id="notyf-text" value="Bravo vous m'avez fait apparaître !"/>
    <x-Form.Select name="notyf_kind" id="notyf-kind" :datas="$notyfs" />
    <x-Form.Btn onClick="notyfJS(document.getElementById('notyf-text').value, document.getElementById('notyf-kind').value);">
        Appuyez pour tester !
    </x-Form.Btn>
</div>