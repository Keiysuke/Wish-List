@extends('template')

@section('breadcrumbs')
    {{ Breadcrumbs::render('edit_purchase', $purchase, $purchase->product) }}
@endsection

@section('content')
@php($dir = config('images.path_products').'/'.$purchase->product_id.'/')
<x-Notification type="success" msg="{{ session('info') }}"/>

<div class="min-w-full max-w-xs">
    <form class="bg-white rounded px-8 pt-6 pb-8 mb-4" action="{{ route('purchases.update', $purchase) }}" method="POST">
        @csrf
        @method('put')
        <div class="relative flex">
            <div class="flex align-start gap-1">
                <x-svg.big.cart class="w-7"/>
                <h1>Edition d'un achat</h1>
            </div>
            <div class="absolute right-0 bottom-0">
                <a href="{{ route('purchases.destroy', $purchase->id) }}" title="Supprimer l'achat" class="title-icon heart cursor-pointer inline-flex" onClick="return confirm('Supprimer l\'achat ?');">
                    <x-svg.trash class="icon-xs"/>
                </a>
            </div>
        </div>
        <hr/>

        <input type="hidden" value="{{ Auth::user()->id }}" name="user_id" id="user-id"/>
        <div class="flex justify-between gap-4 mb-4">
            <div class="flex gap-4 w-2/5">
                <div class="w-1/10">
                    <img src="{{ asset($dir.$purchase->product->photos->firstWhere('ordered', 1)->label) }}" class="h-20"/>
                </div>
                <div class="w-9/10">
                    <x-Form.Label for="product-id" block>Produit acheté</x-Form.Label>
                    <div class="pl-2 pt-2">{{ $purchase->product->label }}</div>
                </div>
            </div>
            <div class="flex gap-4 w-3/5">
                <div class="w-1/3">
                    <x-Form.Label for="product-state-id" block required create="{{ route('states.products.create') }}">Etat du produit</x-Form.Label>
                    <select name="product_state_id" id="product-state-id" class="pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                        @foreach($productStates as $productState)
                            <option value="{{ $productState->id }}" @if(strcmp(old('product_state_id', $purchase->product_state_id), $productState->id) === 0) selected @endif>{{ $productState->label }}</option>
                        @endforeach
                    </select>
                    @error('product_state_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="w-1/3">
                    <x-Form.Label for="date" block required>Date d'achat</x-Form.Label>
                    <x-Form.Date name="date" value="{{ old('date', $purchase->date) }}"/>
                </div>
                <div class="w-1/3">
                    <x-Form.Label for="date-received" block required>Date de réception</x-Form.Label>
                    <x-Form.Date name="date_received" value="{{ old('date_received', $purchase->date_received) }}"/>
                </div>
            </div>
        </div>
        
        <div class="flex gap-4 mb-4">
            <div class="w-2/5">
                <x-Form.Label for="website-id" block required create="{{ route('websites.create') }}">Site web</x-Form.Label>
                <select name="website_id" id="website-id" class="pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                    @foreach($websites as $website)
                        <option value="{{ $website->id }}" @if(strcmp(old('website_id', $purchase->website_id), $website->id) === 0) selected @endif>{{ $website->label }}</option>
                    @endforeach
                </select>
                @error('website_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="flex gap-4 w-3/5">
                <div class="w-1/3">
                    <div class="relative flex inline-flex w-full">
                        <x-Form.Label for="cost" block required>Coût (€)</x-Form.Label>
                        <x-Utils.Convert inputId="cost"/>
                    </div>
                    <x-Form.Input name="cost" placeholder="60" value="{{ old('cost', $purchase->cost) }}"/>
                </div>
                <div class="w-1/3">
                    <x-Form.Label for="discount" block>Réduction (€)</x-Form.Label>
                    <x-Form.Input name="discount" placeholder="0" value="{{ old('discount', $purchase->discount) }}"/>
                </div>
                <div class="w-1/3">
                    <x-Form.Label for="customs" block>Douane (€)</x-Form.Label>
                    <x-Form.Input name="customs" placeholder="0" value="{{ old('customs', $purchase->customs) }}"/>
                </div>
            </div>
        </div>
        <div class="flex items-center justify-between">
            <x-Form.Btn type="submit">Mettre à jour l'achat</x-Form.Btn>
            <x-Form.Cancel href="{{ route('products.show', $purchase->product_id) }}"/>
        </div>
    </form>
</div>
@endsection