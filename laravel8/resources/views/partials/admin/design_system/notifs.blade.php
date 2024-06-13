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

<x-Window.Coding class="mt-4 w-10/12" title="Supprimer une notification d'un utilisateur" major="auth()->user() | ->notifications() | ->whereJsonContains | NotificationCoontroller | app/Notifications/MissingPhotos">
    auth()->user()-><x-Window.Keyword name="notifications"/>()->where('type', '=', 'App\Notifications\FriendRequest')<br />
        -><x-Window.Keyword name="whereJsonContains"/>('data->user_id', $userId)<br />
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

<x-Window.Coding class="mt-4 w-10/12" title="Mes Notyf en JS" major="notyfJS | Notyf | myNotyf">
    notyfJS(<x-Window.Comment>'Message qui sera affiché'</x-Window.Comment>, <x-Window.Comment>'error'</x-Window.Comment>);<br />
    <br />
    <x-Window.Comment>// A retourner par la méthode qui a été appelée en ajax...</x-Window.Comment><br />
    <x-Window.Return/> response()->json([<br />
    <div class="ml-4">
        'success' => true, <br />
        'notyf' => <x-Window.Static name="Notyf" method="success"/>('Your friend can now access your list')<br />
    </div>
    ]);<br />
    <x-Window.Comment>// ...ensuite, du côté de l'appel ajax</x-Window.Comment><br />
    }).then(res => {<br />
        <span class="ml-4">myNotyf(res)</span><br />
    })<br />
</x-Window.Coding>