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


<h3>3. Les champs de saisie</h3>
@php($elements = ['Form.Label', 'showNbChars', 'EventListener on \'input\'', 'app.js'])
<x-admin.help.list_helpers :elements="$elements"/>

<x-Window.Coding class="mt-4 w-10/12" title="Afficher le nombre de caractères saisis">
    < <x-Window.Keyword color="red" name="x-Form.Label"/> <x-Window.Property name="for" value="inputNameId"/> <x-Window.Property name="showNbChars" value="inputNameId"/>>Texte à saisir< / <x-Window.Keyword color="red" name="x-Form.Label"/> ><br />
    < <x-Window.Keyword color="red" name="x-Form.Textarea"/> <x-Window.Property name="name" value="inputNameId"/>>
        Valeur de l'input de saisie
    < / <x-Window.Keyword color="red" name="x-Form.Textarea"/>><br />
</x-Window.Coding >

<div class="my-4">
    <x-Form.Label for="text_example" block showNbChars="text_example">Texte</x-Form.Label>
    <x-Form.Textarea name="text_example">Saisissez un texte</x-Form.Textarea>
</div>