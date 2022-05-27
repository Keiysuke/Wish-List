@extends('template')

@section('breadcrumbs')
    {{ Breadcrumbs::render('create', 'video_game') }}
@endsection

@section('content')
<x-notification type="success" msg="{{ session('info') }}"/>

<div class="min-w-full max-w-xs">
    <form class="bg-white rounded px-8 pt-6 pb-8 mb-4" action="{{ route('video_games.store') }}" method="POST">
        @csrf
        <div class="flex align-start gap-1">
            <x-svg.big.vg_controller class="w-7"/>
            <h1>Création d'un Jeu vidéo</h1>
        </div>
        <hr/>
        
        <input type="hidden" value="{{ Auth::user()->id }}" name="user_id" id="user_id"/>
        <div class="flex gap-4 mb-4">
            <div class="w-2/5">
                <x-form.label for="label" block required>Nom du jeu vidéo</x-form.label>
                <x-form.input name="label" placeholder="Uncharted : Lost Legacy" value="{{ old('label') }}"/>
            </div>
            <div class="w-2/5">
                <x-form.label for="developer_id" block required create="{{ route('vg_developers.create') }}">Studio de développement</x-form.label>
                <select name="developer_id" id="developer_id" class="pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                    @foreach($developers as $developer)
                        <option value="{{ $developer->id }}" @if(old('developer_id') === $developer->id) selected @endif>{{ $developer->label }}</option>
                    @endforeach
                </select>
                @error('developer_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="w-1/5">
                <x-form.label for="date_released" block required>Date de sortie</x-form.label>
                <x-form.date name="date_released" type="date_released" value="{{ old('date_released') }}"/>
            </div>
            <div class="w-1/5">
                <x-form.label for="nb_players" block required>Nombre de joueurs (max)</x-form.label>
                <x-form.input name="nb_players" placeholder="1" value="{{ old('nb_players') }}"/>
            </div>
        </div>
        
        <div class="flex items-center justify-between">
            <x-form.btn type="submit">Ajouter le jeu vidéo</x-form.btn>
            <x-form.cancel href="{{ route('video_games.index') }}"/>
        </div>
    </form>
</div>
@endsection