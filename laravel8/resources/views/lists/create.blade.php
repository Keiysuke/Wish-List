@extends('template')

@section('breadcrumbs')
    {{ Breadcrumbs::render('create', 'list') }}
@endsection

@section('content')
<x-notification type="success" msg="{{ session('info') }}"/>

<div class="min-w-full max-w-xs">
    <form class="bg-white rounded px-8 pt-6 pb-8 mb-4" action="{{ route('lists.store') }}" method="POST">
        @csrf
        <h1>Création d'une liste</h1>
        <hr/>

        <input type="hidden" value="{{ Auth::user()->id }}" name="user_id" id="user_id"/>
        <div class="flex gap-4">
            <div class="w-10/12">
                <x-form.label for="label" block required>Nom de la liste</x-form.label>
                <x-form.input name="label" placeholder="Liste d'envies" value="{{ old('label') }}"/>
            </div>
            <div class="w-2/12 flex justify-center">
                <div class="pt-9">
                    <x-form.checkbox name="secret">{{ old('secret')? 'checked' : '' }}</x-form.checkbox>
                    <x-form.label class="ml-1" for="secret">Garder la surprise ?</x-form.label>
                </div>
            </div>
        </div>
        <div class="my-4">
            <x-form.label for="description" block>Description (facultative)</x-form.label>
            <x-form.textarea name="description">{{ old('description') }}</x-form.textarea>
        </div>

        <div class="flex items-center justify-between">
            <x-form.btn type="submit">Créer la liste</x-form.btn>
            <x-form.cancel href="{{ route('lists.index') }}"/>
        </div>
    </form>
    </div>
@endsection