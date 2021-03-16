@extends('template')

@section('breadcrumbs')
    {{ Breadcrumbs::render('edit_purchase', $purchase, $purchase->product) }}
@endsection

@section('content')
<x-notification type="success" msg="{{ session('info') }}"/>

<div class="min-w-full max-w-xs">
    <form class="bg-white rounded px-8 pt-6 pb-8 mb-4" action="{{ route('purchases.update', $purchase) }}" method="POST">
        @csrf
        @method('put')
        <h1>Edition d'un achat</h1>
        <hr/>

        <input type="hidden" value="{{ Auth::user()->id }}" name="user_id" id="user_id"/>
        <div class="flex justify-between gap-4 mb-4">
            <div class="w-2/3">
                <label class="block text-gray-600 text-sm font-semibold mb-2" for="product_id">Produit acheté</label>
                <div class="pl-2 pt-2">{{ $purchase->product->label }}</div>
            </div>
            <div class="w-1/3">
                <label class="block text-gray-600 text-sm font-semibold mb-2" for="product_state_id">Etat du produit <span class="required">*</span></label>
                <select name="product_state_id" id="product_state_id" class="pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                    @foreach($product_states as $product_state)
                        <option value="{{ $product_state->id }}" @if(strcmp(old('product_state_id', $purchase->product_state_id), $product_state->id) === 0) selected @endif>{{ $product_state->label }}</option>
                    @endforeach
                </select>
                @error('product_state_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        
        <div class="flex gap-4 mb-4">
            <div class="w-2/3">
                <label class="block text-gray-600 text-sm font-semibold mb-2" for="website_id">Site web <span class="required">*</span></label>
                <select name="website_id" id="website_id" class="pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                    @foreach($websites as $website)
                        <option value="{{ $website->id }}" @if(strcmp(old('website_id', $purchase->website_id), $website->id) === 0) selected @endif>{{ $website->label }}</option>
                    @endforeach
                </select>
                @error('website_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="flex gap-4 w-1/3">
                <div class="w-1/2">
                    <label class="block text-gray-600 text-sm font-semibold mb-2" for="cost">Coût (€) <span class="required">*</span></label>
                    <input class="bg-gray-100 appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="cost" id="cost" type="text" placeholder="60" value="{{ old('cost', $purchase->cost) }}"/>
                    @error('cost')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="w-1/2">
                    <label class="block text-gray-600 text-sm font-semibold mb-2" for="date">Date d'achat <span class="required">*</span></label>
                    <input class="bg-gray-100 appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="date" id="date" type="date" value="{{ old('date', $purchase->date) }}"/>
                    @error('date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="flex items-center justify-between">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                Mettre à jour l'achat
            </button>
            <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="{{ route('products.show', $purchase->product_id) }}">Annuler</a>
        </div>
    </form>
</div>
@endsection