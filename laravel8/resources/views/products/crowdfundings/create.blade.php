@extends('template')

@section('breadcrumbs')
    {{ Breadcrumbs::render('product_crowdfunding.create', $product) }}
@endsection

@section('content')
<x-Notification type="success" msg="{{ session('info') }}"/>
<div class="min-w-full max-w-2xl mx-auto">
    <form class="bg-white rounded px-8 pt-6 pb-8 mb-4" action="{{ route('crowdfundings.store') }}" method="POST">
        @csrf
        <h1 class="text-2xl font-bold">Ajouter un projet participatif</h1>
        <hr/>
        <input type="hidden" name="product_id" value="{{ $product->id }}"/>
        <div class="flex gap-4 mb-4">
            <div class="w-2/4">
                <x-Form.Label for="project_name" block required>Nom du projet</x-Form.Label>
                <x-Form.Input name="project_name" placeholder="Nom du projet participatif"/>
            </div>
            <div class="w-1/4">
                <x-Form.Label for="website_id" block required>Site web</x-Form.Label>
                <select name="website_id" class="form-input w-full">
                    @foreach($websites as $website)
                        <option value="{{ $website->id }}">{{ $website->label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-1/4">
                <x-Form.Label for="state_id" block>Avancée du projet</x-Form.Label>
                <select name="state_id" class="form-input w-full">
                    @foreach($crowdfundingStates as $state)
                        <option value="{{ $state->id }}">{{ $state->label }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="flex gap-4 mb-4">
            <div class="w-2/4">
                <x-Form.Label for="project_url" block>URL du projet</x-Form.Label>
                <x-Form.Input name="project_url" placeholder="https://kickstarter.com/..."/>
            </div>
            <div class="w-1/4">
                <x-Form.Label for="goal_amount" block>Objectif (€)</x-Form.Label>
                <x-Form.Input name="goal_amount" type="number" step="1" placeholder="10000"/>
            </div>
            <div class="w-1/4">
                <x-Form.Label for="current_amount" block>Atteint (€)</x-Form.Label>
                <x-Form.Input name="current_amount" type="number" step="1" placeholder="5000"/>
            </div>
        </div>
        <div class="flex gap-4 mb-4">
            <div class="w-1/3">
                <x-Form.Label for="start_date" block required>Date de début</x-Form.Label>
                <x-Form.Date name="start_date"/>
            </div>
            <div class="w-1/3">
                <x-Form.Label for="end_date" block required>Date de fin</x-Form.Label>
                <x-Form.Date name="end_date"/>
            </div>
            <div class="w-1/3">
                <x-Form.Label for="shipping_date" block>Date d'envoi des produits</x-Form.Label>
                <x-Form.Date name="shipping_date"/>
            </div>
        </div>
        <div class="flex items-center justify-between">
            <x-Form.Btn type="submit">Créer le projet</x-Form.Btn>
            <x-Form.Cancel href="{{ route('products.show', $product->id) }}"/>
        </div>
    </form>
</div>
@endsection
