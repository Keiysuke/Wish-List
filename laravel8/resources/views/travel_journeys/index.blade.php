@extends('template')

@section('breadcrumbs')
    {{ Breadcrumbs::render('list', 'travel_journey') }}
@endsection

@section('content')
<x-Notification type="success" msg="{{ session('info') }}"/>
<form>
    <div class="relative flex">
        <h1>Mes voyages</h1>
        <div class="absolute right-0 bottom-0">
            <a href="{{ route('travel_journeys.create') }}" title="Créer un nouveau voyage" class="title-icon cursor-pointer inline-flex">
                <x-svg.plus class="icon-xs"/>
            </a>
        </div>
    </div>
    <hr/>
</form>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    @foreach($journeys as $journey)
        <div class="bg-white rounded shadow p-4">
            <h2 class="font-bold text-lg mb-2">{{ $journey->label }}</h2>
            <div class="mb-2">
                <span class="font-semibold">Étapes :</span>
                <ul>
                    @foreach($journey->travelSteps as $step)
                        <li>{{ $step->city->name }} ({{ $step->start_date }} - {{ $step->end_date ?? '...' }})</li>
                    @endforeach
                </ul>
            </div>
            <a href="#" class="btn btn-primary">Voir</a>
            <a href="{{ route('travel_journeys.edit', $journey->id) }}" class="btn btn-secondary">Éditer</a>
        </div>
    @endforeach
</div>
@endsection
