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
        
        @include('partials.video_games.forms.create', compact('today', 'developers'))
        
        <div class="flex items-center justify-between">
            <x-Form.Btn type="submit">Ajouter le jeu vidéo</x-Form.Btn>
            <x-Form.Cancel href="{{ route('video_games.index') }}"/>
        </div>
    </form>
</div>
@endsection