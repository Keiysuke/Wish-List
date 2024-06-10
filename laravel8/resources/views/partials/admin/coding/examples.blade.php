<div class="wrap_h1 mt-8">
    <h1>Exemples de code</h1>
    <x-svg.big.cmd class="icon-lg"/>
</div>

<x-Window.Coding class="mt-4 w-10/12" title="Utiliser une vue en tant que String" major="renderAsString | renderComponent">
    <x-Window.Use>Illuminate\Support\Facades\Blade;<br /></x-Window.Use>
    <br />
    <x-Window.Var var="name"/> = 'John Doe';<br />
    <x-Window.Var var="viewContent"/> = Blade::renderAsString('welcome', ['name' => $name]);<br />
    <x-Window.Comment>// Maintenant $viewContent contient le HTML rendu<br /></x-Window.Comment>
    <br />
    <x-Window.Var var="alertContent"/> = Blade::renderComponent(\App\View\Components\Alert::class, ['type' => 'success'], 'This is a success alert.');<br />
    <x-Window.Comment>// Maintenant $alertContent contient le HTML rendu du composant Alert<br /></x-Window.Comment>
</x-Window.Coding>