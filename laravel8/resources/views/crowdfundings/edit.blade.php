@extends('template')

@section('breadcrumbs')
    {{ Breadcrumbs::render('crowdfundings.edit', $crowdfunding) }}
@endsection

@section('content')
<x-Notification type="success" msg="{{ session('info') }}"/>
<div class="min-w-full max-w-2xl mx-auto">
    <form class="bg-white rounded px-8 pt-6 pb-8 mb-4" action="{{ route('crowdfundings.update', $crowdfunding) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="relative flex items-center mb-4">
            <x-svg.big.idea class="w-8 h-8 text-green-600 mr-2"/>
            <h1 class="text-2xl font-bold">Éditer le projet participatif</h1>
        </div>
        <hr class="mb-4"/>
        <div class="flex gap-4 mb-4">
            <div class="w-1/2">
                <x-Form.Label for="product_id" block required>Produit associé</x-Form.Label>
                <select name="product_id" class="form-input w-full">
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" @if(old('product_id', $crowdfunding->product_id) == $product->id) selected @endif>{{ $product->label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-1/2">
                <x-Form.Label for="website_id" block required>Site web</x-Form.Label>
                <select name="website_id" class="form-input w-full">
                    @foreach($websites as $website)
                        <option value="{{ $website->id }}" @if(old('website_id', $crowdfunding->website_id) == $website->id) selected @endif>{{ $website->label }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="flex gap-4 mb-4">
            <div class="w-2/3">
                <x-Form.Label for="project_name" block required>Nom du projet</x-Form.Label>
                <x-Form.Input name="project_name" value="{{ old('project_name', $crowdfunding->project_name) }}" placeholder="Nom du projet participatif"/>
            </div>
            <div class="w-1/3">
                <x-Form.Label for="status" block>Avancée du projet</x-Form.Label>
                <select name="status" class="form-input w-full">
                    <option value="">Sélectionner un statut</option>
                    @foreach($crowdfundingStates as $status)
                        <option value="{{ $status->id }}" @if(old('status', $crowdfunding->status) == $status->id) selected @endif>{{ $status->label }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="flex gap-4 mb-4">
            <div class="w-2/3">
                <x-Form.Label for="project_url" block>URL du projet</x-Form.Label>
                <x-Form.Input name="project_url" value="{{ old('project_url', $crowdfunding->project_url) }}" placeholder="https://kickstarter.com/..."/>
            </div>
            <div class="w-1/3 flex gap-2">
                <div class="w-1/2">
                    <x-Form.Label for="goal_amount" block>Objectif (€)</x-Form.Label>
                    <x-Form.Input name="goal_amount" type="number" step="0.01" value="{{ old('goal_amount', $crowdfunding->goal_amount) }}" placeholder="10000"/>
                </div>
                <div class="w-1/2">
                    <x-Form.Label for="current_amount" block>Atteint (€)</x-Form.Label>
                    <x-Form.Input name="current_amount" type="number" step="0.01" value="{{ old('current_amount', $crowdfunding->current_amount) }}" placeholder="5000"/>
                </div>
            </div>
        </div>
        <div class="flex gap-4 mb-4">
            <div class="w-1/3">
                <x-Form.Label for="start_date" block>Date de début</x-Form.Label>
                <x-Form.Date name="start_date" value="{{ old('start_date', $crowdfunding->start_date) }}"/>
            </div>
            <div class="w-1/3">
                <x-Form.Label for="end_date" block>Date de fin</x-Form.Label>
                <x-Form.Date name="end_date" value="{{ old('end_date', $crowdfunding->end_date) }}"/>
            </div>
            <div class="w-1/3">
                <x-Form.Label for="shipping_date" block>Date d'envoi des produits</x-Form.Label>
                <x-Form.Date name="shipping_date" value="{{ old('shipping_date', $crowdfunding->shipping_date) }}"/>
            </div>
        </div>
        <div class="flex items-center justify-between">
            <x-Form.Btn type="submit">Enregistrer</x-Form.Btn>
            <x-Form.Cancel href="{{ route('myProducts') }}"/>
        </div>
    </form>
</div>
@endsection
