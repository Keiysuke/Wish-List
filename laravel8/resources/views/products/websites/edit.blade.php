@extends('template')

@section('breadcrumbs')
    {{ Breadcrumbs::render('edit_product_website', $product_website) }}
@endsection

@section('content')
<x-notification type="success" msg="{{ session('info') }}"/>

<div class="min-w-full max-w-xs">
    <form class="bg-white rounded px-8 pt-6 pb-8 mb-4" action="{{ route('product_websites.update', $product_website) }}" method="POST">
        @csrf
        @method('put')
        <h1>Edition d'un site de vente</h1>
        <hr/>

        <div class="flex gap-4 my-4">
            <div class="w-1/2">
                <x-form.label for="website_id" block required>Site de vente</x-form.label>
                <select name="website_id" id="website_id" class="pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                    @foreach($websites as $website)
                        <option value="{{ $website->id }}" @if(old('website_id', $product_website->website_id) == $website->id) selected @endif>{{ $website->label }}</option>
                    @endforeach
                </select>
                @error('website_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="flex gap-4 w-1/2">
                <div class="w-1/3">
                    <x-form.label for="price" block required>Prix du site (€)</x-form.label>
                    <x-form.input  name="price" placeholder="50" value="{{ old('price', $product_website->price) }}"/>
                </div>
                <div class="w-1/3">
                    <x-form.label for="available_date" block>Date de disponibilité</x-form.label>
                    <x-form.datetime name="available_date" value="{{ old('available_date', (is_null($product_website->available_date)? '' : date('Y-m-d', strtotime($product_website->available_date)).'T'.date('H:i', strtotime($product_website->available_date)))) }}"/>
                </div>
                <div class="w-1/3">
                    <x-form.label for="expiration_date" block>Date d'expiration</x-form.label>
                    <x-form.datetime name="expiration_date" value="{{ old('expiration_date', (is_null($product_website->expiration_date)? '' : date('Y-m-d', strtotime($product_website->expiration_date)).'T'.date('H:i', strtotime($product_website->expiration_date)))) }}"/>
                </div>
            </div>
        </div>
        <div class="mb-4">
            <x-form.label for="url" block>Url</x-form.label>
            <x-form.input name="url"  placeholder="http://Amazon.fr" value="{{ old('url', $product_website->url) }}"/>
        </div>
        <div class="flex items-center justify-between">
            <x-form.btn type="submit">Modifier les sites de vente</x-form.btn>
            <x-form.cancel href="{{ route('products.show', $product_website->product->id) }}"/>
        </div>
    </form>
    </div>
@endsection