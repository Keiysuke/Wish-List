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
                <label class="block text-gray-600 text-sm font-semibold mb-2" for="website_id">Site de vente <span class="required">*</span></label>
                <select name="website_id" id="website_id" class="pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                    @foreach($websites as $website)
                        <option value="{{ $website->id }}" @if(old('website_id', $product_website->website_id) === $website->id) selected @endif>{{ $website->label }}</option>
                    @endforeach
                </select>
                @error('website_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="flex gap-4 w-1/2">
                <div class="w-1/3">
                    <label class="block text-gray-600 text-sm font-semibold mb-2" for="price">Prix du site (€) <span class="required">*</span></label>
                    <input class="bg-gray-100 appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="price" id="price" type="text" placeholder="50" value="{{ old('price', $product_website->price) }}"/>
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="w-1/3">
                    <label class="block text-gray-600 text-sm font-semibold mb-2" for="available_date">Date de disponibilité</label>
                    <input class="bg-gray-100 appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="available_date" id="available_date" type="datetime-local" value="{{ old('available_date', (is_null($product_website->available_date)? '' : date('Y-m-d', strtotime($product_website->available_date)).'T'.date('H:i', strtotime($product_website->available_date)))) }}"/>
                    @error('available_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="w-1/3">
                    <label class="block text-gray-600 text-sm font-semibold mb-2" for="expiration_date">Date d'expiration</label>
                    <input class="bg-gray-100 appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="expiration_date" id="expiration_date" type="datetime-local" value="{{ old('expiration_date', (is_null($product_website->expiration_date)? '' : date('Y-m-d', strtotime($product_website->expiration_date)).'T'.date('H:i', strtotime($product_website->expiration_date)))) }}"/>
                    @error('expiration_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="mb-4">
            <label class="block text-gray-600 text-sm font-semibold mb-2" for="url">Url</label>
            <input class="bg-gray-100 appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="url" id="url" type="text" placeholder="http://Amazon.fr" value="{{ old('url', $product_website->url) }}"/>
            @error('url')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="flex items-center justify-between">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                Modifier les sites de vente
            </button>
            <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="{{ route('products.show', $product_website->product->id) }}">Annuler</a>
        </div>
    </form>
    </div>
@endsection