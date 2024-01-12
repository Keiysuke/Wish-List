<div class="wrap_h1 mt-8">
    <h1>Liste des composants de formulaire</h1>
    <x-svg.clipboard_list class="icon-lg"/>
</div>

<h3>1. Les boutons</h3>
@php($elements = ['CssColor', 'x-form-btn', '[CSS] text-blue-500 (text, bg, border)'])
<x-admin.help.list_helpers :elements="$elements"/>

<div class="grid grid-cols-10 gap-4">
    @foreach($colors as $color)
        <x-form.btn color="{{ $color }}">{{ $color }}</x-form.btn>
    @endforeach
</div>
