<div class="wrap_h1 mt-8">
    <h1>Liste des composants de formulaire</h1>
    <x-svg.clipboard_list class="icon-lg"/>
</div>

<h3>1. Les boutons</h3>
@php($elements = ['CssColor', 'x-Form-Btn', '[CSS] text-blue-500 (text, bg, border)'])
<x-admin.help.list_helpers :elements="$elements"/>

<div class="grid grid-cols-10 gap-4">
    @foreach($colors as $color)
        <x-Form.Btn color="{{ $color }}">{{ $color }}</x-Form.Btn>
    @endforeach
</div>

<h3>2. Les composants</h3>

<x-Window.Coding class="mt-4 w-10/12" title="Composant dynamique" major="x-dynamic-component">
    < <x-Window.Keyword color="red" name="x-dynamic-component"/> :component="<x-Window.Var var="section"/>->icon" class="icon-sm" /><br />
</x-Window.Coding >