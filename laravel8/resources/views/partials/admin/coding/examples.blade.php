<div class="wrap_h1 mt-8">
    <h1>Exemples de code</h1>
    <x-svg.big.cmd class="icon-lg"/>
</div>

<div class="flex flex-col gap-8">
    <x-Window.Coding class="w-10/12" title="Utiliser une vue en tant que String" major="renderAsString | renderComponent">
        <x-Window.Use>Illuminate\Support\Facades\Blade;<br /></x-Window.Use>
        <br />
        <x-Window.Var var="name"/> = 'John Doe';<br />
        <x-Window.Var var="viewContent"/> = Blade::renderAsString('welcome', ['name' => $name]);<br />
        <x-Window.Comment>// Maintenant $viewContent contient le HTML rendu<br /></x-Window.Comment>
        <br />
        <x-Window.Var var="alertContent"/> = Blade::renderComponent(\App\View\Components\Alert::class, ['type' => 'success'], 'This is a success alert.');<br />
        <x-Window.Comment>// Maintenant $alertContent contient le HTML rendu du composant Alert<br /></x-Window.Comment>
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
            <x-Window.EscapeOutput class="ml-4"><x-Window.Var var="datas"/>->links()<br /></x-Window.EscapeOutput>
        < /footer><br />
    </x-Window.Coding>
</div>