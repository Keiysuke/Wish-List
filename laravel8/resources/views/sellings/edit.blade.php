@extends('template')

@section('breadcrumbs')
    {{ Breadcrumbs::render('edit_selling', $selling, $selling->product) }}
@endsection

@section('content')
@php($dir = config('images.path_products').'/'.$selling->product_id.'/')
<x-Notification type="success" msg="{{ session('info') }}"/>

<div class="min-w-full max-w-xs">
    <form class="bg-white rounded px-8 pt-6 pb-8 mb-4" action="{{ route('sellings.update', $selling) }}" method="POST">
        @csrf
        @method('put')
        <div class="relative flex">
            <div class="flex align-start gap-1">
                <x-svg.big.truck class="w-7"/>
                <h1>Edition d'une vente</h1>
            </div>
            <div class="absolute right-0 bottom-0">
                <a href="{{ route('sellings.destroy', $selling->id) }}" title="Supprimer la vente" class="title-icon heart cursor-pointer inline-flex" onClick="return confirm('Supprimer la vente ?');">
                    <x-svg.trash class="icon-xs"/>
                </a>
            </div>
        </div>
        <hr/>

        <input type="hidden" value="{{ Auth::user()->id }}" name="user_id" id="user-id"/>
        <div class="flex justify-between gap-4 mb-4">
            <div class="flex gap-4 w-1/2">
                <div class="w-1/10">
                    <img src="{{ asset($dir.$selling->product->photos->firstWhere('ordered', 1)->label) }}" class="h-20"/>
                </div>
                <div class="w-9/10">
                    <x-Form.Label for="product-id" block required>Produit à vendre</x-Form.Label>
                    <div class="p-2">{{ $selling->product->label }}</div>
                    <input type="hidden" name="product_id" id="product-id" value="{{ $selling->product_id }}"/>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 w-1/2">
                <div>
                    <x-Form.Label for="product-state-id" block required create="{{ route('states.products.create') }}">Etat du produit</x-Form.Label>
                    <select name="product_state_id" id="product-state-id" class="pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                        @foreach($productStates as $productState)
                            <option value="{{ $productState->id }}" @if(strcmp(old('product_state_id', $selling->product_state_id), $productState->id) === 0) selected @endif>{{ $productState->label }}</option>
                        @endforeach
                    </select>
                    @error('product_state_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="pt-9">
                    <x-Form.Checkbox name="box">{{ old('box', $selling->box)? 'checked' : '' }}</x-Form.Checkbox>
                    <x-Form.Label class="ml-1" for="box">Avec la boîte</x-Form.Label>
                </div>
            </div>
        </div>
        <div class="flex justify-between gap-4 mb-4">
            <div class="w-1/2">
                <x-Form.Label for="website-id" block required create="{{ route('websites.create') }}">Vendu sur</x-Form.Label>
                <select name="website_id" id="website-id" class="pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                    @foreach($websites as $website)
                        <option value="{{ $website->id }}" @if(strcmp(old('website_id', $selling->website_id), $website->id) === 0) selected @endif>{{ $website->label }}</option>
                    @endforeach
                </select>
                @error('website_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="grid grid-cols-2 gap-4 w-1/2">
                <div>
                    <x-Form.Label for="sell-state-id" block required>Avancée de la vente</x-Form.Label>
                    <select name="sell_state_id" id="sell-state-id" class="pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                        @foreach($sellStates as $sellState)
                            <option value="{{ $sellState->id }}" @if(strcmp(old('sell_state_id', $selling->sell_state_id), $sellState->id) === 0) selected @endif>{{ $sellState->label }}</option>
                        @endforeach
                    </select>
                    @error('sell_state_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <x-Form.Label for="nb-views">Nombre de vues (€)</x-Form.Label>
                    <x-Form.Input name="nb_views" placeholder="0" value="{{ old('nb_views', $selling->nb_views) }}"/>
                </div>
            </div>
        </div>
        <div class="flex gap-4 mb-4">
            <div class="w-1/4">
                <x-Form.Label for="price" required>Mon prix de vente (€)</x-Form.Label>
                <x-Form.Input name="price" placeholder="80" value="{{ old('price', $selling->price) }}"/>
            </div>
            <div class="w-1/4">
                <x-Form.Label for="shipping-fees">Frais de port (€)</x-Form.Label>
                <x-Form.Input name="shipping_fees" placeholder="7.95" value="{{ old('shipping_fees', $selling->shipping_fees) }}"/>
            </div>
            <div class="w-1/4">
                <x-Form.Label for="confirmed-price">Prix de vente confirmé (€)</x-Form.Label>
                <x-Form.Input name="confirmed_price" placeholder="80" value="{{ old('confirmed_price', $selling->confirmed_price) }}"/>
            </div>
            <div class="w-1/4">
                <x-Form.Label for="shipping-fees-payed">Frais de port payés (€)</x-Form.Label>
                <x-Form.Input name="shipping_fees_payed" placeholder="8" value="{{ old('shipping_fees_payed', $selling->shipping_fees_payed) }}"/>
            </div>
        </div>
        <div class="flex gap-4 mb-4">
            <div class="w-1/3">
                <x-Form.Label for="date-begin" block>Date de début de la vente</x-Form.Label>
                <x-Form.Date name="date_begin" value="{{ old('date_begin', $selling->date_begin) }}"/>
            </div>
            <div class="w-1/3">
                <x-Form.Label for="date-sold" block>Date de confirmation de vente</x-Form.Label>
                <x-Form.Date name="date_sold" value="{{ old('date_sold', $selling->date_sold) }}"/>
            </div>
            <div class="w-1/3">
                <x-Form.Label for="date-send" block>Date d'envoi du colis</x-Form.Label>
                <x-Form.Date name="date_send" value="{{ old('date_send', $selling->date_send) }}"/>
            </div>
        </div>
        <div class="flex items-center justify-between">
            <x-Form.Btn type="submit">Modifier la vente</x-Form.Btn>
            <x-Form.Cancel href="{{ route('products.show', $selling->product_id) }}"/>
        </div>
    </form>
    </div>
@endsection