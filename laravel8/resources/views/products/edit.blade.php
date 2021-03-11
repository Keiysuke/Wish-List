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
                <label class="block text-gray-600 text-sm font-semibold mb-2" for="label">Nom du produit <span class="required">*</span></label>
                <input class="bg-gray-100 appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="label" id="label" type="text" placeholder="Uncharted 4" value="{{ old('label', $product->label) }}"/>
                @error('label')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="flex justify-around w-1/2 gap-4">
                <div class="w-1/2">
                    <label class="block text-gray-600 text-sm font-semibold mb-2" for="limited_edition">Edition limitée ?</label>
                    <input class="bg-gray-100 appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="limited_edition" id="limited_edition" type="text" placeholder="3000" value="{{ old('limited_edition', $product->limited_edition) }}"/>
                    @error('limited_edition')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="w-1/2">
                    <label class="block text-gray-600 text-sm font-semibold mb-2" for="real_cost">Prix neuf (€) <span class="required">*</span></label>
                    <input class="bg-gray-100 appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="real_cost" id="real_cost" type="text" placeholder="20.50" value="{{ old('real_cost', $product->real_cost) }}"/>
                    @error('real_cost')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="mb-4">
            <label class="block text-gray-600 text-sm font-semibold mb-2" for="description">Description <span class="required">*</span></label>
            <textarea rows="4" cols="50" class="bg-gray-100 p-1 appearance-none border rounded w-full text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="description" id="description" type="text"/>{{ old('description', $product->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="flex items-center justify-between">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                Modifier le produit
            </button>
            <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="{{ route('products.show', $product->id) }}">Annuler</a>
        </div>
    </form>
    </div>
@endsection