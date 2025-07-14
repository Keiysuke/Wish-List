@extends('template')

@section('breadcrumbs')
    {{ Breadcrumbs::render('create_psn_video_game') }}
@endsection

@section('content')
<x-Notification type="success" msg="{{ session('info') }}"/>

<div class="min-w-full max-w-xs">
    <form class="bg-white rounded px-8 pt-6 pb-8 mb-4" action="{{ route('storePsnVideoGame') }}" method="POST">
        @csrf
        <div class="flex align-start gap-1">
            <x-svg.big.vg_controller class="w-7"/>
            <h1>Création des jeux du PS+</h1>
        </div>
        <hr/>
        
        <input type="hidden" value="{{ auth()->user()->id }}" name="user_id" id="user-id"/>
        
        <div class="flex gap-4 mb-4 items-center justify-center">
            <div class="w-1/5">
                <x-Form.Label for="ps_month" block required>Mois</x-Form.Label>
                <select name="ps_month" id="ps_month" class="pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                    <option value="1" @if(old('ps_month') == '1') selected @endif>Janvier</option>
                    <option value="2" @if(old('ps_month') == '2') selected @endif>Février</option>
                    <option value="3" @if(old('ps_month') == '3') selected @endif>Mars</option>
                    <option value="4" @if(old('ps_month') == '4') selected @endif>Avril</option>
                    <option value="5" @if(old('ps_month') == '5') selected @endif>Mai</option>
                    <option value="6" @if(old('ps_month') == '6') selected @endif>Juin</option>
                    <option value="7" @if(old('ps_month') == '7') selected @endif>Juillet</option>
                    <option value="8" @if(old('ps_month') == '8') selected @endif>Août</option>
                    <option value="9" @if(old('ps_month') == '9') selected @endif>Septembre</option>
                    <option value="10" @if(old('ps_month') == '10') selected @endif>Octobre</option>
                    <option value="11" @if(old('ps_month') == '11') selected @endif>Novembre</option>
                    <option value="12" @if(old('ps_month') == '12') selected @endif>Décembre</option>
                </select>
                @error('ps_month')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="w-1/5">
                <x-Form.Label for="ps_year" block required>Année</x-Form.Label>
                <x-Form.Input name="ps_year" placeholder="2025" value="{{ old('ps_year', 2025) }}"/>
            </div>
        </div>
        
        
        <div class="flex align-start gap-1 text-red-700">
            <x-svg.big.vg_controller class="icon-xs"/>
            <h2>Liste des jeux</h2>
        </div>
        <hr/>
        @for($nb = 0; $nb < 3; $nb++)
            @include('partials.video_games.forms.create', compact('today', 'developers', 'nb'))
        @endfor
        
        <div class="flex items-center justify-between">
            <x-Form.Btn type="submit">Ajouter les jeux Psn</x-Form.Btn>
            <x-Form.Cancel href="{{ route('video_games.index') }}"/>
        </div>
    </form>
</div>
@endsection