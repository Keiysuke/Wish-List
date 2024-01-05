@extends('template')

@section('breadcrumbs')
    {{ Breadcrumbs::render('create_product_website', $product) }}
@endsection

@section('js')
<script type="text/javascript" src="{{ URL::asset('js/my_fetch.js') }}"></script>
<script>
    document.getElementById('ws_url').addEventListener('change', (e) => {
        const url = e.target.value;
        my_fetch('{{ route('find_by_url') }}', {method: 'post', csrf: true}, {
            url: url,
        }).then(response => {
            if (response.ok) {
                return response.json();
            }
        }).then(res => {
            document.getElementById('website_id').value = res.id;
        });
    });
</script>
@endsection

@section('content')
<x-notification type="success" msg="{{ session('info') }}"/>

<div class="min-w-full max-w-xs">
    <form class="bg-white rounded px-8 pt-6 pb-8 mb-4" action="{{ route('product_websites.store', $product->id) }}" method="POST">
        @csrf
        <h1>Lier un site de vente</h1>
        <hr/>
        
        <div class="flex gap-4 my-4">
            <div class="w-1/2">
                <x-form.label for="website_id" block required>Site de vente</x-form.label>
                <select name="website_id" id="website_id" class="pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                    @foreach($websites as $website)
                        <option value="{{ $website->id }}" @if(old('website_id') === $website->id) selected @endif>{{ $website->label }}</option>
                    @endforeach
                </select>
                @error('website_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="flex gap-4 w-1/2">
                <div class="w-1/3">
                    <x-form.label for="price" block required>Prix du site (€)</x-form.label>
                    <x-form.input name="price" placeholder="50" value="{{ old('price') }}"/>
                </div>
                <div class="w-1/3">
                    <x-form.label for="available_date" block>Date de disponibilité</x-form.label>
                    <x-form.datetime name="available_date" value="{{ old('available_date') }}"/>
                </div>
                <div class="w-1/3">
                    <x-form.label for="expiration_date" block>Date d'expiration</x-form.label>
                    <x-form.datetime name="expiration_date" value="{{ old('expiration_date') }}"/>
                </div>
            </div>
        </div>
        <div class="mb-4">
            <x-form.label for="url" block>Url</x-form.label>
            <x-form.input id="ws_url" name="url" placeholder="http://Amazon.fr" value="{{ old('url') }}"/>
        </div>
        <div class="flex items-center justify-between">
            <x-form.btn type="submit">Lier le site de vente</x-form.btn>
            <x-form.cancel href="{{ route('products.show', $product->id) }}"/>
        </div>
    </form>
    </div>
@endsection