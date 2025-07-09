@extends('template')

@section('breadcrumbs')
    {{ Breadcrumbs::render('show', 'travel_journey', $travelJourney) }}
@endsection

@section('content')
<div class="container mx-auto p-4">
    <div class="relative flex justify-center border-b-2 mb-4">
        <h1>{{ $travelJourney->label }}</h1>
        <div class="absolute right-0">
            <a title="Editer le voyage" href="{{ route('travel_journeys.edit', $travelJourney->id) }}" class="title-icon inline-flex">
                <x-svg.edit class="icon-xs"/>
            </a>
        </div>
    </div>

    <h2 class="text-xl font-semibold mb-2">Étapes du voyage</h2>
    <ul class="mb-4">
        @foreach($travelJourney->travelSteps as $step)
            <li class="mb-2 p-2 bg-gray-100 rounded">
                <strong>Ville :</strong> {{ $step->city->name }}<br>
                <strong>Date d'arrivée :</strong> {{ $step->start_date }}<br>
                <strong>Date de départ :</strong> {{ $step->end_date ?? '...' }}<br>
            </li>
        @endforeach
    </ul>
</div>
@endsection
