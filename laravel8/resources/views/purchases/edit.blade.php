@extends('template')

@section('breadcrumbs')
    {{ Breadcrumbs::render('edit_purchase', $purchase, $purchase->product) }}
@endsection

@section('content')
@php($dir = config('images.path_products').'/'.$purchase->product_id.'/')
<x-notification type="success" msg="{{ session('info') }}"/>

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

        <input type="hidden" value="{{ Auth::user()->id }}" name="user_id" id="user_id"/>
        <div class="flex justify-between gap-4 mb-4">
            <div class="flex gap-4 w-2/5">
                <div class="w-1/10">
                    <img src="{{ asset($dir.$purchase->product->photos->firstWhere('ordered', 1)->label) }}" class="h-20"/>
                </div>
                <div class="w-9/10">
                    <x-form.label for="product_id" block>Produit acheté</x-form.label>
                    <div class="pl-2 pt-2">{{ $purchase->product->label }}</div>
                </div>
            </div>
            <div class="flex gap-4 w-3/5">
                <div class="w-2/3">
                    <x-form.label for="product_state_id" block required>Etat du produit</x-form.label>
                    <select name="product_state_id" id="product_state_id" class="pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                        @foreach($product_states as $product_state)
                            <option value="{{ $product_state->id }}" @if(strcmp(old('product_state_id', $purchase->product_state_id), $product_state->id) === 0) selected @endif>{{ $product_state->label }}</option>
                        @endforeach
                    </select>
                    @error('product_state_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="w-1/3">
                    <x-form.label for="date" block required>Date d'achat</x-form.label>
                    <x-form.date name="date" value="{{ old('date', $purchase->date) }}"/>
                </div>
            </div>
        </div>
        
        <div class="flex gap-4 mb-4">
            <div class="w-2/5">
                <x-form.label for="website_id" block required>Site web</x-form.label>
                <select name="website_id" id="website_id" class="pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
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
                    <x-form.label for="cost" block required>Coût (€)</x-form.label>
                    <x-form.input name="cost" placeholder="60" value="{{ old('cost', $purchase->cost) }}"/>
                </div>
                <div class="w-1/3">
                    <x-form.label for="discount" block>Réduction (€)</x-form.label>
                    <x-form.input name="discount" placeholder="0" value="{{ old('discount', $purchase->discount) }}"/>
                </div>
                <div class="w-1/3">
                    <x-form.label for="customs" block>Douane (€)</x-form.label>
                    <x-form.input name="customs" placeholder="0" value="{{ old('customs', $purchase->customs) }}"/>
                </div>
            </div>
        </div>
        <div class="flex items-center justify-between">
            <x-form.btn type="submit">Mettre à jour l'achat</x-form.btn>
            <x-form.cancel href="{{ route('products.show', $purchase->product_id) }}"/>
        </div>
    </form>
</div>
@endsection