@extends('template')

@section('breadcrumbs')
    {{ Breadcrumbs::render('edit', 'video_game', $videoGame) }}
@endsection

@section('content')
<x-Notification type="success" msg="{{ session('info') }}"/>

<div class="min-w-full max-w-xs">
    <form class="bg-white rounded px-8 pt-6 pb-8 mb-4" action="{{ route('video_games.update', $videoGame) }}" method="POST">
        @csrf
        @method('put')
        <div class="relative flex">
            <div class="flex align-start gap-1">
                <x-svg.big.vg_controller class="w-7"/>
                <h1>Edition d'un Jeu vidéo</h1>
            </div>
            <div class="absolute right-0 bottom-0">
                <a href="{{ route('video_games.create') }}" title="Créer un nouveau Jeu Vidéo" class="title-icon cursor-pointer inline-flex">
                    <x-svg.plus class="icon-xs"/>
                </a>
            </div>
        </div>
        <hr/>
        
        <input type="hidden" value="{{ auth()->user()->id }}" name="user_id" id="user-id"/>
        <div class="flex gap-4 mb-4 items-center">
            <div class="w-2/5">
                <x-Form.Label for="label" block required>Nom du jeu vidéo</x-Form.Label>
                <x-Form.Input name="label" placeholder="Uncharted : Lost Legacy" value="{{ old('label', $videoGame->label) }}"/>
            </div>
            <div class="w-2/5">
                <x-Form.Label for="developer-id" block required create="{{ route('vg_developers.create') }}">Studio de développement</x-Form.Label>
                <select name="developer_id" id="developer-id" class="pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                    @foreach($developers as $developer)
                        <option value="{{ $developer->id }}" @if(strcmp(old('developer_id', $videoGame->developer_id), $developer->id) === 0) selected @endif>{{ $developer->label }}</option>
                    @endforeach
                </select>
                @error('developer_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="w-1/5">
                <x-Form.Label for="date-released" block required>Date de sortie</x-Form.Label>
                <x-Form.Date name="date_released" type="date_released" value="{{ old('date_released', $videoGame->date_released) }}"/>
            </div>
            <div class="w-1/5">
                <x-Form.Label for="nb-players" block required>Nombre de joueurs (max)</x-Form.Label>
                <x-Form.Input name="nb_players" placeholder="1" value="{{ old('nb_players', $videoGame->nb_players) }}"/>
            </div>
        </div>
        
        <div class="flex items-center justify-between">
            <x-Form.Btn type="submit">Modifier le jeu vidéo</x-Form.Btn>
            <x-Form.Cancel href="{{ route('video_games.show', $videoGame->id) }}"/>
        </div>
    </form>
</div>
@endsection