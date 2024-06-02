@extends('template')

@section('breadcrumbs')
    {{ Breadcrumbs::render('edit_product_website', $productWebsite) }}
@endsection

@section('content')
<x-Notification type="success" msg="{{ session('info') }}"/>

<div class="min-w-full max-w-xs">
    <form class="bg-white rounded px-8 pt-6 pb-8 mb-4" action="{{ route('productWebsites.update', $productWebsite) }}" method="POST">
        @csrf
        @method('put')
        <h1>Edition d'un site de vente</h1>
        <hr/>

        <div class="flex gap-4 my-4">
            <div class="w-1/2">
                <x-Form.Label for="website-id" block required>Site de vente</x-Form.Label>
                <select name="website_id" id="website-id" class="pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                    @foreach($websites as $website)
                        <option value="{{ $website->id }}" @if(old('website_id', $productWebsite->website_id) == $website->id) selected @endif>{{ $website->label }}</option>
                    @endforeach
                </select>
                @error('website_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="flex gap-4 w-1/2">
                <div class="w-1/3">
                    <x-Form.Label for="price" block required>Prix du site (€)</x-Form.Label>
                    <x-Form.Input  name="price" placeholder="50" value="{{ old('price', $productWebsite->price) }}"/>
                </div>
                <div class="w-1/3">
                    <x-Form.Label for="available-date" block>Date de disponibilité</x-Form.Label>
                    <x-Form.Datetime name="available_date" value="{{ old('available_date', (is_null($productWebsite->available_date)? '' : date('Y-m-d', strtotime($productWebsite->available_date)).'T'.date('H:i', strtotime($productWebsite->available_date)))) }}"/>
                </div>
                <div class="w-1/3">
                    <x-Form.Label for="expiration-date" block>Date d'expiration</x-Form.Label>
                    <x-Form.Datetime name="expiration_date" value="{{ old('expiration_date', (is_null($productWebsite->expiration_date)? '' : date('Y-m-d', strtotime($productWebsite->expiration_date)).'T'.date('H:i', strtotime($productWebsite->expiration_date)))) }}"/>
                </div>
            </div>
        </div>
        <div class="mb-4">
            <x-Form.Label for="url" block>Url</x-Form.Label>
            <x-Form.Input name="url"  placeholder="http://Amazon.fr" value="{{ old('url', $productWebsite->url) }}"/>
        </div>
        <div class="flex items-center justify-between">
            <x-Form.Btn type="submit">Modifier les sites de vente</x-Form.Btn>
            <x-Form.Cancel href="{{ route('products.show', $productWebsite->product->id) }}"/>
        </div>
    </form>
    </div>
@endsection