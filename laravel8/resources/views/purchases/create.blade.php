@extends('template')

@section('breadcrumbs')
    {{ Breadcrumbs::render('create_purchase', $product) }}
@endsection

@section('js')
<script>
    function set_selling(v){
        document.getElementById('section_selling').classList.toggle('hidden');
        document.getElementById('section_selling').classList.toggle('block');
    }
</script>
@endsection

@section('content')
<x-notification type="success" msg="{{ session('info') }}"/>

<div class="min-w-full max-w-xs">
    <form class="bg-white rounded px-8 pt-6 pb-8 mb-4" action="{{ route('purchases.store') }}" method="POST">
        @csrf
        <h1>Création d'un achat</h1>
        <hr/>
        
        <input type="hidden" value="{{ Auth::user()->id }}" name="user_id" id="user_id"/>
        <div class="flex justify-between gap-4 mb-4">
            <div class="w-2/3">
                <input type="hidden" value="{{ $product->id }}" name="product_id" id="product_id"/>
                <label class="block text-gray-600 text-sm font-semibold mb-2" for="product_id">Produit acheté</label>
                <div class="pl-2 pt-2">{{ $product->label }}</div>
            </div>
            <div class="w-1/3">
                <label class="block text-gray-600 text-sm font-semibold mb-2" for="product_state_id">Etat du produit <span class="required">*</span></label>
                <select name="product_state_id" id="product_state_id" class="pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                    @foreach($product_states as $product_state)
                        <option value="{{ $product_state->id }}" @if(old('product_state_id') === $product_state->id) selected @endif>{{ $product_state->label }}</option>
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
                        <option value="{{ $website->id }}" @if(old('website_id') === $website->id) selected @endif>{{ $website->label }}</option>
                    @endforeach
                </select>
                @error('website_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="flex gap-4 w-1/3">
                <div class="w-1/2">
                    <label class="block text-gray-600 text-sm font-semibold mb-2" for="cost">Coût (€) <span class="required">*</span></label>
                    <input class="bg-gray-100 appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="cost" id="cost" type="text" placeholder="Ce produit m'a coûté..." value="{{ old('cost') }}"/>
                    @error('cost')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="w-1/2">
                    <label class="block text-gray-600 text-sm font-semibold mb-2" for="date">Date d'achat <span class="required">*</span></label>
                    <input class="bg-gray-100 appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="date" id="date" type="date" value="{{ old('date') }}"/>
                    @error('date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Formulaire de vente -->
        
        <div id="section_selling" class="{{ strcmp(old('add_selling'), 'on') === 0 ? 'block' : 'hidden' }}">
            <h1 class="text-green-500">Données sur la vente effectuée</h1>
            <hr class="border-green-500"/>
            
            <div class="flex justify-between gap-4 mb-4">
                <div class="w-1/2">
                    <label class="block text-gray-600 text-sm font-semibold mb-2" for="product_id">Produit à vendre</label>
                    <div class="pl-2 pt-2">{{ $product->label }}</div>
                </div>
                <div class="grid grid-cols-2 gap-4 w-1/2">
                    <div>
                        <label class="block text-gray-600 text-sm font-semibold mb-2" for="sell_product_state_id">Etat du produit <span class="required">*</span></label>
                        <select name="sell_product_state_id" id="sell_product_state_id" class="pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                            @foreach($product_states as $product_state)
                                <option value="{{ $product_state->id }}" @if(old('sell_product_state_id') == $product_state->id) selected @endif>{{ $product_state->label }}</option>
                            @endforeach
                        </select>
                        @error('sell_product_state_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="pt-9">
                        <input type="checkbox" class="mr-1" name="box" id="box" {{ old('box')? 'checked' : '' }}>
                        <label class="text-gray-600 text-sm font-semibold mb-2" for="box">Avec la boîte <span class="required">*</span></label>
                    </div>
                </div>
            </div>
            <div class="flex justify-between gap-4 mb-4">
                <div class="w-1/2">
                    <label class="block text-gray-600 text-sm font-semibold mb-2" for="sell_website_id">Vendu sur <span class="required">*</span></label>
                    <select name="sell_website_id" id="sell_website_id" class="pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                        @foreach($websites as $website)
                            <option value="{{ $website->id }}" @if(old('sell_website_id') == $website->id) selected @endif>{{ $website->label }}</option>
                        @endforeach
                    </select>
                    @error('sell_website_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="grid grid-cols-2 gap-4 w-1/2">
                    <div>
                        <label class="block text-gray-600 text-sm font-semibold mb-2" for="sell_state_id">Avancée de la vente <span class="required">*</span></label>
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
                        <label class="block text-gray-600 text-sm font-semibold mb-2" for="nb_views">Nombre de vues</label>
                        <input class="bg-gray-100 appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="nb_views" id="nb_views" type="text" placeholder="0" value="{{ old('nb_views') }}"/>
                        @error('nb_views')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="flex gap-4 mb-4">
                <div class="w-1/4">
                    <label class="block text-gray-600 text-sm font-semibold mb-2" for="price">Mon prix de vente (€) <span class="required">*</span></label>
                    <input class="bg-gray-100 appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="price" id="price" type="text" placeholder="80" value="{{ old('price') }}"/>
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="w-1/4">
                    <label class="block text-gray-600 text-sm font-semibold mb-2" for="shipping_fees">Frais de port (€)</label>
                    <input class="bg-gray-100 appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="shipping_fees" id="shipping_fees" type="text" placeholder="7.95" value="{{ old('shipping_fees') }}"/>
                    @error('shipping_fees')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="w-1/4">
                    <label class="block text-gray-600 text-sm font-semibold mb-2" for="confirmed_price">Prix de vente confirmé (€)</label>
                    <input class="bg-gray-100 appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="confirmed_price" id="confirmed_price" type="text" placeholder="80" value="{{ old('confirmed_price') }}"/>
                    @error('confirmed_price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="w-1/4">
                    <label class="block text-gray-600 text-sm font-semibold mb-2" for="shipping_fees_payed">Frais de port payés (€)</label>
                    <input class="bg-gray-100 appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="shipping_fees_payed" id="shipping_fees_payed" type="text" placeholder="8" value="{{ old('shipping_fees_payed') }}"/>
                    @error('shipping_fees_payed')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="flex gap-4 mb-4">
                <div class="w-1/3">
                    <label class="block text-gray-600 text-sm font-semibold mb-2" for="date_begin">Date de début de la vente</label>
                    <input class="bg-gray-100 appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="date_begin" id="date_begin" type="date" value="{{ old('date_begin') }}"/>
                    @error('date_begin')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="w-1/3">
                    <label class="block text-gray-600 text-sm font-semibold mb-2" for="date_sold">Date de confirmation de vente</label>
                    <input class="bg-gray-100 appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="date_sold" id="date_sold" type="date" value="{{ old('date_sold') }}"/>
                    @error('date_sold')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="w-1/3">
                    <label class="block text-gray-600 text-sm font-semibold mb-2" for="date_send">Date d'envoi du colis</label>
                    <input class="bg-gray-100 appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="date_send" id="date_send" type="date" value="{{ old('date_send') }}"/>
                    @error('date_send')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="mb-4">
            <input onChange="set_selling(this.checked);" class="mr-1" type="checkbox" name="add_selling" id="add_selling" {{ strcmp(old('add_selling'), 'on') === 0 ? 'checked' : '' }}/>
            <label class="text-gray-600 text-sm font-semibold mb-2" for="add_selling">Créer & lier une vente</label>
        </div>
        <div class="flex items-center justify-between">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                Ajouter l'achat
            </button>
            <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="{{ route('products.show', $product->id) }}">Annuler</a>
        </div>
    </form>
    </div>
@endsection