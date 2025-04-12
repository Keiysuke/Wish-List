@extends('template')

@section('breadcrumbs')
    {{ Breadcrumbs::render('create', 'video_game') }}
@endsection

@section('content')
<x-Notification type="success" msg="{{ session('info') }}"/>

<div class="min-w-full max-w-xs">
    <form class="bg-white rounded px-8 pt-6 pb-8 mb-4" action="{{ route('video_games.store') }}" method="POST">
        @csrf
        <div class="flex align-start gap-1">
            <x-svg.big.vg_controller class="w-7"/>
            <h1>Création d'un Jeu vidéo</h1>
        </div>
        <hr/>
        
        <input type="hidden" value="{{ auth()->user()->id }}" name="user_id" id="user-id"/>
        <div class="flex gap-4 mb-4 items-center">
            <div class="w-2/5">
                <x-Form.Label for="label" block required>Nom du jeu vidéo</x-Form.Label>
                <x-Form.Input name="label" placeholder="Uncharted : Lost Legacy" value="{{ old('label') }}"/>
            </div>
            <div class="w-2/5">
                <x-Form.Label for="developer-id" block required create="{{ route('vg_developers.create') }}">Studio de développement</x-Form.Label>
                <select name="developer_id" id="developer-id" class="pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                    <option value="to_create">A créer</option>
                    @foreach($developers as $developer)
                        <option value="{{ $developer->id }}" @if(old('developer_id') === $developer->id) selected @endif>{{ $developer->label }}</option>
                    @endforeach
                </select>
                @error('developer_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="w-1/5">
                <x-Form.Label for="date-released" block required>Date de sortie</x-Form.Label>
                <x-Form.Date name="date_released" type="date_released" value="{{ old('date_released', $today) }}"/>
            </div>
            <div class="w-1/5">
                <x-Form.Label for="nb-players" block required>Nombre de joueurs (max)</x-Form.Label>
                <x-Form.Input name="nb_players" placeholder="1" value="{{ old('nb_players', 1) }}"/>
            </div>
        </div>
        
        <div class="flex items-center justify-between">
            <x-Form.Btn type="submit">Ajouter le jeu vidéo</x-Form.Btn>
            <x-Form.Cancel href="{{ route('video_games.index') }}"/>
        </div>
    </form>
</div>
@endsection