@extends('template')

@section('metas')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('edit_travel_journey', $travelJourney) }}
@endsection

@section('js')
<script type="text/javascript" src="{{ URL::asset('js/my_fetch.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/travelJourneys.js') }}"></script>
@endsection

@section('content')
<x-Notification type="success" msg="{{ session('info') }}"/>

<div class="min-w-full max-w-xs">
    <form class="bg-white rounded px-8 pt-6 pb-8 mb-4" action="{{ route('travel_journeys.update', $travelJourney->id) }}" method="POST">
        @csrf
        @method('put')
        <h1>Édition du voyage</h1>
        <hr/>

        <input type="hidden" value="{{ $travelJourney->user_id }}" name="user_id" id="user-id"/>

        <div class="flex justify-center gap-4 mb-4">
            <div class="w-1/2">
                <x-Form.Label for="label" block required>Nom du voyage</x-Form.Label>
                <x-Form.Input name="label" placeholder="Road trip Italie" value="{{ old('label', $travelJourney->label) }}"/>
            </div>
        </div>

        <!-- Liste des étapes du voyage -->
        <h1 class="flex inline-flex text-emerald-500">
            <x-svg.big.map_pin class="icon-lg text-red-500"/>
            Étapes du voyage
        </h1>
        <hr class="border-emerald-500"/>
        
        @php($nbSteps = old('max_nb_travel_steps', $travelJourney->travelSteps()->count() ?? 0))
        <input type="hidden" id="max-nb-travel-steps" name="max_nb_travel_steps" value="{{ old('max_nb_travel_steps', $nbSteps) }}"/>
        @error('max_nb_travel_steps')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <div id="all-travel-steps" class="flex flex-col gap-4 my-4">
            @for($nb = 0; $nb < $nbSteps; $nb++)
                @php($step = old('travel_steps.'.$nb) ? (object) old('travel_steps.'.$nb) : ($travelJourney->travelSteps[$nb] ?? null))
                @include('partials.travel_journeys.select_travel_step', ['nb' => $nb, 'step' => $step])
            @endfor
        </div>

        <div class="flex gap-4 items-center mb-4">
            <select name="StepNbToAdd" id="travel-step-nb-to-add" class="pl-2 h-10 block rounded-md bg-gray-100 border-transparent">
                @for($i = 1; $i <= 10; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
            <x-Form.BtnPlus id="add-travel-step" mb="0">Ajouter une étape</x-Form.BtnPlus>
        </div>

        <div class="flex items-center justify-between">
            <x-Form.Btn type="submit">Mettre à jour le voyage</x-Form.Btn>
            <x-Form.Cancel href="{{ route('travel_journeys.index') }}"/>
        </div>
    </form>
</div>
@endsection
