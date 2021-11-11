@extends('template')

@section('breadcrumbs')
    {{ Breadcrumbs::render('edit', 'product', $product) }}
@endsection

@section('content')
@php($dir = config('images.path_products').'/'.$product->id.'/')
<x-notification type="success" msg="{{ session('info') }}"/>

<div class="min-w-full max-w-xs">
    <form class="bg-white rounded px-8 pt-6 pb-8 mb-4" action="{{ route('products.update', $product) }}" method="POST">
        @csrf
        @method('put')
        <h1>Edition du produit</h1>
        <hr/>
        
        <div class="flex gap-4 mb-4">
            <div class="w-1/12 flex justify-center">
                <img src="{{ asset($dir.$product->photos->firstWhere('ordered', 1)->label) }}" class="h-20"/>
            </div>
            <div <div class="w-5/12">
                <x-form.label for="label" block required>Nom du produit</x-form.label>
                <x-form.input name="label" placeholder="Uncharted 4" value="{{ old('label', $product->label) }}"/>
            </div>
            <div class="flex justify-around w-6/12 gap-4">
                <div class="w-1/2">
                    <x-form.label for="tag_ids" block required>Tags associés</x-form.label>
                    <select multiple name="tag_ids[]" id="tag_ids" class="pl-2 h-32 block w-full rounded-md bg-gray-100 border-transparent">
                        @foreach($tags as $tag)
                            <option value="{{ $tag->id }}" @if(in_array($tag->id, old('tags_id', $product->tag_ids()))) selected @endif>{{ $tag->label }}</option>
                        @endforeach
                    </select>
                    @error('product_state_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
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
        </div>
        <div class="mb-4">
            <x-form.label for="description" block>Description</x-form.label>
            <x-form.textarea name="description">{{ old('description', $product->description) }}</x-form.textarea>
        </div>
        <div class="flex items-center justify-between">
            <x-form.btn type="submit">Modifier le produit</x-form.btn>
            <x-form.cancel href="{{ route('products.show', $product->id) }}"/>
        </div>
    </form>
    </div>
@endsection