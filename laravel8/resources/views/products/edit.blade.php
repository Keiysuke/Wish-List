@extends('template')

@section('breadcrumbs')
    {{ Breadcrumbs::render('edit', 'product', $product) }}
@endsection

@section('content')
<x-notification type="success" msg="{{ session('info') }}"/>

<div class="min-w-full max-w-xs">
    <form class="bg-white rounded px-8 pt-6 pb-8 mb-4" action="{{ route('products.update', $product) }}" method="POST">
        @csrf
        @method('put')
        <h1>Edition du produit</h1>
        <hr/>
        
        <div class="flex gap-4 mb-4">
            <div <div class="w-1/2">
                <x-form.label for="label" block required>Nom du produit</x-form.label>
                <x-form.input name="label" placeholder="Uncharted 4" value="{{ old('label', $product->label) }}"/>
            </div>
            <div class="flex justify-around w-1/2 gap-4">
                <div class="w-1/2">
                    <x-form.label for="limited_edition">Edition limitée ?</x-form.label>
                    <x-form.input name="limited_edition" placeholder="3000" value="{{ old('limited_edition', $product->limited_edition) }}"/>
                </div>
                <div class="w-1/2">
                    <x-form.label for="real_cost" required>Prix neuf (€)</x-form.label>
                    <x-form.input name="real_cost" placeholder="20.50" value="{{ old('real_cost', $product->real_cost) }}"/>
                </div>
            </div>
        </div>
        <div class="mb-4">
            <x-form.label for="description" block required>Description</x-form.label>
            <x-form.textarea name="description">{{ old('description', $product->description) }}</x-form.textarea>
        </div>
        <div class="flex items-center justify-between">
            <x-form.btn type="submit">Modifier le produit</x-form.btn>
            <x-form.cancel href="{{ route('products.show', $product->id) }}"/>
        </div>
    </form>
    </div>
@endsection