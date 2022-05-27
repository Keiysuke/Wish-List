@extends('template')

@section('breadcrumbs')
    {{ Breadcrumbs::render('create_selling', $purchase, $purchase->product) }}
@endsection

@section('content')
@php($dir = config('images.path_products').'/'.$purchase->product_id.'/')
<x-notification type="success" msg="{{ session('info') }}"/>

<div class="min-w-full max-w-xs">
    <form class="bg-white rounded px-8 pt-6 pb-8 mb-4" action="{{ route('sellings.store') }}" method="POST">
        @csrf
        <div class="flex align-start gap-1">
            <x-svg.big.truck class="w-7"/>
            <h1>Nouvelle vente</h1>
        </div>
        <hr/>

        <input type="hidden" value="{{ Auth::user()->id }}" name="user_id" id="user_id"/>
        <div class="flex justify-between gap-4 mb-4">
            <div class="flex gap-4 w-1/2">
                <div class="w-1/10">
                    <img src="{{ asset($dir.$purchase->product->photos->firstWhere('ordered', 1)->label) }}" class="h-20"/>
                </div>
                <div class="w-9/10">
                    <x-form.label for="product_id" block required>Produit à vendre</x-form.label>
                    <div class="p-2">{{ $purchase->product->label }}</div>
                    <input type="hidden" name="purchase_id" id="purchase_id" value="{{ $purchase->id }}"/>
                    <input type="hidden" name="product_id" id="product_id" value="{{ $purchase->product_id }}"/>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 w-1/2">
                <div>
                    <x-form.label for="product_state_id" block required create="{{ route('states.products.create') }}">Etat du produit</x-form.label>
                    <select name="product_state_id" id="product_state_id" class="pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                        @foreach($product_states as $product_state)
                            <option value="{{ $product_state->id }}" @if(old('product_state_id') == $product_state->id) selected @endif>{{ $product_state->label }}</option>
                        @endforeach
                    </select>
                    @error('product_state_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="pt-9">
                    <x-form.checkbox name="box">{{ old('box')? 'checked' : '' }}</x-form.checkbox>
                    <x-form.label class="ml-1" for="box">Avec la boîte</x-form.label>
                </div>
            </div>
        </div>
        <div class="flex justify-between gap-4 mb-4">
            <div class="w-1/2">
                <x-form.label for="website_id" block required create="{{ route('websites.create') }}">Vendu sur</x-form.label>
                <select name="website_id" id="website_id" class="pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                    @foreach($websites as $website)
                        <option value="{{ $website->id }}" @if(old('website_id', \App\Models\Website::where('label', 'Ebay')->first()->id) == $website->id) selected @endif>{{ $website->label }}</option>
                    @endforeach
                </select>
                @error('website_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="grid grid-cols-2 gap-4 w-1/2">
                <div>
                    <x-form.label for="sell_state_id" block required>Avancée de la vente</x-form.label>
                    <select name="sell_state_id" id="sell_state_id" class="pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                        @foreach($sell_states as $sell_state)
                            <option value="{{ $sell_state->id }}" @if(old('sell_state_id') == $sell_state->id) selected @endif>{{ $sell_state->label }}</option>
                        @endforeach
                    </select>
                    @error('sell_state_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <x-form.label for="nb_views" block>Nombre de vues</x-form.label>
                    <x-form.input name="nb_views" placeholder="0" value="{{ old('nb_views') }}"/>
                </div>
            </div>
        </div>
        <div class="flex gap-4 mb-4">
            <div class="w-1/4">
                <label for="price" block required>Mon prix de vente (€)</label>
                <x-form.input name="price" placeholder="80" value="{{ old('price') }}"/>
            </div>
            <div class="w-1/4">
                <x-form.label for="shipping_fees" block>Frais de port (€)</x-form.label>
                <x-form.input name="shipping_fees" placeholder="7.95" value="{{ old('shipping_fees') }}"/>
            </div>
            <div class="w-1/4">
                <x-form.label for="confirmed_price" block>Prix de vente confirmé (€)</x-form.label>
                <x-form.input name="confirmed_price" placeholder="80" value="{{ old('confirmed_price') }}"/>
            </div>
            <div class="w-1/4">
                <x-form.label for="shipping_fees_payed" block>Frais de port payés (€)</x-form.label>
                <x-form.input name="shipping_fees_payed" placeholder="8" value="{{ old('shipping_fees_payed') }}"/>
            </div>
        </div>
        <div class="flex gap-4 mb-4">
            <div class="w-1/3">
                <x-form.label for="date_begin" block>Date de début de la vente</x-form.label>
                <x-form.date name="date_begin" value="{{ old('date_begin') }}"/>
            </div>
            <div class="w-1/3">
                <x-form.label for="date_sold" block>Date de confirmation de vente</x-form.label>
                <x-form.date name="date_sold" value="{{ old('date_sold') }}"/>
            </div>
            <div class="w-1/3">
                <x-form.label for="date_send" block>Date d'envoi du colis</x-form.label>
                <x-form.date name="date_send" value="{{ old('date_send') }}"/>
            </div>
        </div>

        <div class="flex items-center justify-between">
            <x-form.btn type="submit">Ajouter la vente</x-form.btn>
            <x-form.cancel href="{{ route('products.show', $purchase->product_id) }}"/>
        </div>
    </form>
    </div>
@endsection