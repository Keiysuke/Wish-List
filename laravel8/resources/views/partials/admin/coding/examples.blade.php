<div class="wrap_h1 mt-8">
    <h1>Exemples de code</h1>
    <x-svg.big.cmd class="icon-lg"/>
</div>

<div class="flex flex-col gap-8">
    <h3 class="my-0">1. PHP / Blade</h3>
    <x-Window.Coding class="w-10/12" title="Utiliser une vue en tant que String" major="renderAsString | renderComponent">
        <x-Window.Use>Illuminate\Support\Facades\Blade;<br /></x-Window.Use>
        <br />
        <x-Window.Var var="name"/> = 'John Doe';<br />
        <x-Window.Var var="viewContent"/> = Blade::renderAsString('welcome', ['name' => $name]);<br />
        <x-Window.Comment>// Maintenant $viewContent contient le HTML rendu<br /></x-Window.Comment>
        <br />
        <x-Window.Var var="alertContent"/> = Blade::renderComponent(\App\View\Components\Alert::class, ['type' => 'success'], 'This is a success alert.');<br />
        <x-Window.Comment>// Maintenant $alertContent contient le HTML rendu du composant Alert<br /></x-Window.Comment>
        <br />
        <x-Window.Comment>// 2 - Dans le contrôleur<br /></x-Window.Comment>
        <x-Window.Return/> <x-Window.Keyword name="view"/>('partials.ma_vue')-><x-Window.Keyword name="with"/>(compact('notif'))-><x-Window.Keyword name="render"/>();<br />
        <x-Window.Comment>// Dans la vue<br /></x-Window.Comment>
        <x-Window.Keyword name=""/> { !! <x-Window.Static name="\App\Services\NotificationService" method="renderNotif"/>(<x-Window.Var var="notif"/>) !! }<br />
        <x-Window.Comment>// En traitant le rendu des balises HTML<br /></x-Window.Comment>
        <x-Window.Keyword name=""/> { !! <x-Window.Keyword name="nl2br"/>(<x-Window.Var var="desc"/>) !! }<br />
        <br />
    </x-Window.Coding>

    <x-Window.Coding class="w-10/12" title="La pagination en Ajax" major="vendor/pagination/tailwind | useAjax = true">
        <x-Window.Comment>// Récupérer les données à paginer<br /></x-Window.Comment>
        <x-Window.Var var="datas"/> = <x-Window.Static name="Selling" method="all"/>()<br />
        <x-Window.Var var="datas"/> = <x-Window.Var var="datas"/>->sortBy('date')->paginate(15);<br />
        <x-Window.Comment>// Ne pas oublier lorsque la pagination est affichée en ajax...<br /></x-Window.Comment>
        <x-Window.Var var="datas"/>->useAjax = true;<br />
        <x-Window.Var var="paginator"/> = (object)['cur_page' => <x-Window.Var var="datas"/>->links()->paginator->currentPage()]<br />
        <x-Window.Comment>// Parcourir les données pour les afficher dans la vue...<br /></x-Window.Comment>
        <x-Window.Directive name="foreach"/>($datas as $data)<br />
        <x-Window.Directive name="endforeach"/><br />
        <br />
        <x-Window.Comment>// Le système de pagination à afficher quand $data > 0<br /></x-Window.Comment>
        < footer id="paginate" class="card-footer flex justify-center p-4"><br />
            <x-Window.EscapeOutput class="ml-4"><x-Window.Var var="datas"/>->links()</x-Window.EscapeOutput><br />
        < /footer><br />
    </x-Window.Coding>
    
    <h3 class="my-0">2. SQL</h3>

    <x-Window.Coding kind="SQL" class="w-10/12" title="Débugguer du SQL" major="DB | enableQueryLog | getQueryLog">
        <x-Window.Function public name="shareItem"><x-Window.Var var="type"/> = 'list'</x-Window.Function><br />
        <div class="ml-4">
            <x-Window.Static name="\DB" method="enableQueryLog"/>();
            <x-Window.Keyword name="dd"/>(<x-Window.Static name="\DB" method="getQueryLog"/>());<br />
            <x-Window.Keyword name="dd"/>(<x-Window.Var var="products"/>);<br />
            <x-Window.Keyword name="die"/>();<br />
        </div>
    </x-Window.Coding>

    <h3 class="my-0">3. Javascript</h3>

    <x-Window.Coding kind="JS" class="w-10/12" title="Lancer une fonction JS toutes les 5 secondes" major="SetInterval">
        <x-Window.Keyword name="showMsg" color="purple"/>() {<br />
            <div class="ml-4">
                console.<x-Window.Keyword name="log"/>('test')<br />
            </div>
        }<br />
        <x-Window.Keyword name="setInterval"/>(showMsg, 5000)<br />
    </x-Window.Coding>

    <x-Window.Coding kind="JS" class="w-10/12" title="Passer une url route() au JS" major="select2 | initSelect2 | templates.js">
        <x-Window.Tag name="select"><x-Window.Property name="data-url" value="{ { route('autocomplete') } }"/></x-Window.Tag>
    </x-Window.Coding>

    <x-Window.Coding kind="JS" class="w-10/12" title="Lancer un appel ajax" major="POST => myFetch | GET => getFetch">
        <x-Window.Keyword name="myFetch"/>(' { { route('externalSearch') } }', {<x-Window.Keyword name="method" color="red"/>: 'post', <x-Window.Keyword name="csrf" color="red"/>: true}, {<br />
            <div class="ml-4">
                <x-Window.Keyword name="kind" color="red"/>: kind,<br />
                <x-Window.Keyword name="search" color="red"/>: document.<x-Window.Keyword name="getElementById"/>('sb-'+kind+'-text').value,<br />
            </div>
        }).<x-Window.Keyword name="then"/>(response => {<br />
            <span class="ml-4">if (response.ok) <x-Window.Return/> response.<x-Window.Keyword name="json"/>();<br /></span>
        }).<x-Window.Keyword name="then"/>(results => {<br />
            <span class="ml-4">window.<x-Window.Keyword name="open"/>(results.link);<br /></span>
        }).<x-Window.Keyword name="catch"/>(error => {<br />
            <span class="ml-4"><x-Window.Keyword name="notyfJS"/>(error, 'error'); <x-Window.Comment>// Gérer les erreurs<br /></x-Window.Comment></span>
        });<br />
        <br />
        <x-svg.warning class="warning icon-sm"/><x-Window.Comment>il faut renseigner l'url pour que cela fonctionne<br /></x-Window.Comment>
        <x-Window.Keyword name="getFetch"/>('user/request/user/' + friendId + '/befriend')<br />
    </x-Window.Coding>
</div>