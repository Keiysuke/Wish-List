<div class="wrap_h1 mt-8">
    <h1>Liste des notifications</h1>
    <x-svg.big.bell class="icon-lg"/>
</div>

<h3>1. Les notifications de formulaire</h3>
@php($elements = ['x-notification'])
<x-admin.help.list_helpers :elements="$elements"/>

<x-notification type="success" msg="Exemple de message d'action réussie" example/>
<x-notification type="error" msg="Exemple de message d'action echouée" example/>

<h3>2. Les notifications en attente</h3>
@php($elements = ['NotificationService', 'x-notif'])
<x-admin.help.list_helpers :elements="$elements"/>

<div class="grid grid-cols-3 gap-4">
    @foreach($notifications as $kind => $notif)
        <div class="grid justify-items-center">
            <x-notif :notif="$notif" kind="{{ $kind }}" title="{{ $notif->title }}">
                Vous pouvez insérer tout type de contenu ici
            </x-notif>
        </div>
    @endforeach
</div>

<h3>2. Les notifications dynamiques</h3>
@php($elements = ['my_notyf.js', 'Notyf'])
<x-admin.help.list_helpers :elements="$elements"/>

<div class="flex flex-wrap justify-center gap-4">
    <x-form.input name="notyf_text" id="notyf_text" value="Bravo vous m'avez fait apparaître !"/>
    <x-form.select name="notyf_kind" id="notyf_kind" :datas="$notyfs" />
    <x-form.btn onClick="notyfJS(document.getElementById('notyf_text').value, document.getElementById('notyf_kind').value);">Appuyez pour tester !</x-form.btn>
</div>