@extends('template')

@section('breadcrumbs')
    {{ Breadcrumbs::render('create_purchase', $product) }}
@endsection

@section('js')
<script>
    function set_selling(v){
        document.getElementById('section-selling').classList.toggle('hidden');
        document.getElementById('section-selling').classList.toggle('block');
    }
</script>
@endsection

@section('content')
@php($dir = config('images.path_products').'/'.$product->id.'/')
<x-Notification type="success" msg="{{ session('info') }}"/>

@php($best_cost = $product->best_offer->price)
<div class="min-w-full max-w-xs">
    <form class="bg-white rounded px-8 pt-6 pb-8 mb-4" action="{{ route('purchases.store') }}" method="POST">
        @csrf
        <div class="flex align-start gap-1">
            <x-svg.big.cart class="w-7"/>
            <h1>Création d'un achat</h1>
        </div>
        <hr/>
        
        <input type="hidden" value="{{ auth()->user()->id }}" name="user_id" id="user-id"/>
        <div class="flex justify-between gap-4 mb-4">
            <div class="flex gap-4 w-2/5">
                <div class="w-1/10">
                    <img src="{{ $product->pict }}" class="h-20"/>
                </div>
                <div class="w-9/10">
                    <input type="hidden" value="{{ $product->id }}" name="product_id" id="product-id"/>
                    <x-Form.Label for="product-id" block>Produit acheté</x-Form.Label>
                    <div class="pl-2 pt-2">{{ $product->label }}</div>
                </div>
            </div>
            <div class="flex gap-4 w-3/5">
                <div class="w-1/3">
                    <x-Form.Label for="product-state-id" block required create="{{ route('states.products.create') }}">Etat du produit</x-Form.Label>
                    <select name="product_state_id" id="product-state-id" class="pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                        @foreach($productStates as $productState)
                            <option value="{{ $productState->id }}" @if(old('product_state_id') === $productState->id) selected @endif>{{ $productState->label }}</option>
                        @endforeach
                    </select>
                    @error('product_state_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="w-1/3">
                    <x-Form.Label for="date" block required>Date d'achat</x-Form.Label>
                    <x-Form.Date name="date" type="date" value="{{ old('date', $today) }}"/>
                </div>
                <div class="w-1/3">
                    <x-Form.Label for="date-received" block required>Date de réception</x-Form.Label>
                    <x-Form.Date name="date_received" value="{{ old('date_received') }}"/>
                </div>
            </div>
        </div>
        
        <div class="flex gap-4 mb-4">
            <div class="w-2/5">
                <x-Form.Label for="website-id" block required create="{{ route('websites.create') }}">Site web</x-Form.Label>
                <select name="website_id" id="website-id" class="pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                    @php($best_website_id = $product->best_offer->website_id)
                    @foreach($websites as $website)
                        <option value="{{ $website->id }}" @if(old('website_id', $best_website_id) == $website->id) selected @endif>{{ $website->label }}</option>
                    @endforeach
                </select>
                @error('website_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="flex gap-4 w-3/5">
                <div class="w-1/3">
                    <x-Form.Label for="cost" block required>Coût (€)</x-Form.Label>
                    <x-Form.Input name="cost" placeholder="Ce produit m'a coûté..." value="{{ old('cost', $best_cost) }}"/>
                </div>
                <div class="w-1/3">
                    <x-Form.Label for="discount" block>Réduction (€)</x-Form.Label>
                    <x-Form.Input name="discount" placeholder="0" value="{{ old('discount') }}"/>
                </div>
                <div class="w-1/3">
                    <x-Form.Label for="customs" block>Douane (€)</x-Form.Label>
                    <x-Form.Input name="customs" placeholder="0" value="{{ old('customs') }}"/>
                </div>
            </div>
        </div>

        <!-- Formulaire de vente -->
        
        <div id="section-selling" class="{{ strcmp(old('add_selling'), 'on') === 0 ? 'block' : 'hidden' }}">
            <h1 class="text-green-500">Données sur la vente effectuée</h1>
            <hr class="border-green-500"/>
            
            <div class="flex justify-between gap-4 mb-4">
                <div class="w-1/2">
                    <x-Form.Label for="product-id" block>Produit à vendre</x-Form.Label>
                    <div class="pl-2 pt-2">{{ $product->label }}</div>
                </div>
                <div class="grid grid-cols-2 gap-4 w-1/2">
                    <div>
                        <x-Form.Label for="sell-product-state-id" block required create="{{ route('states.products.create') }}">Etat du produit</x-Form.Label>
                        <select name="sell_product_state_id" id="sell-product-state-id" class="pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                            @foreach($productStates as $productState)
                                <option value="{{ $productState->id }}" @if(old('sell_product_state_id') == $productState->id) selected @endif>{{ $productState->label }}</option>
                            @endforeach
                        </select>
                        @error('sell_product_state_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="pt-9">
                        <x-Form.Checkbox name="box">{{ old('box')? 'checked' : '' }}</x-Form.Checkbox>
                        <x-Form.Label class="ml-1" for="box">Avec la boîte</x-Form.Label>
                    </div>
                </div>
            </div>
            <div class="flex justify-between gap-4 mb-4">
                <div class="w-1/2">
                    <x-Form.Label for="sell-website-id" block required>Vendu sur</x-Form.Label>
                    <select name="sell_website_id" id="sell-website-id" class="pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                        @foreach($websites as $website)
                            <option value="{{ $website->id }}" @if(old('sell_website_id', auth()->user()->getFavWebsite('sell')) == $website->id) selected @endif>{{ $website->label }}</option>
                        @endforeach
                    </select>
                    @error('sell_website_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="grid grid-cols-2 gap-4 w-1/2">
                    <div>
                        <x-Form.Label for="sell-state-id" required>Avancée de la vente</x-Form.Label>
                        <select name="sell_state_id" id="sell-state-id" class="pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                            @foreach($sellStates as $sellState)
                                <option value="{{ $sellState->id }}" @if(old('sell_state_id') == $sellState->id) selected @endif>{{ $sellState->label }}</option>
                            @endforeach
                        </select>
                        @error('sell_state_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <x-Form.Label for="nb-views">Nombre de vues</x-Form.Label>
                        <x-Form.Input name="nb_views" placeholder="0" value="{{ old('nb_views') }}"/>
                    </div>
                </div>
            </div>
            <div class="flex gap-4 mb-4">
                <div class="w-1/4">
                    <x-Form.Label for="price" block required>Mon prix de vente (€)</x-Form.Label>
                    <x-Form.Input name="price" placeholder="80" value="{{ old('price') }}"/>
                </div>
                <div class="w-1/4">
                    <x-Form.Label for="shipping-_fees" block>Frais de port (€)</x-Form.Label>
                    <x-Form.Input name="shipping_fees" placeholder="7.95" value="{{ old('shipping_fees') }}"/>
                </div>
                <div class="w-1/4">
                    <x-Form.Label for="confirmed-price" block>Prix de vente confirmé (€)</x-Form.Label>
                    <x-Form.Input name="confirmed_price" placeholder="80" value="{{ old('confirmed_price') }}"/>
                </div>
                <div class="w-1/4">
                    <x-Form.Label for="shipping-fees-payed" block>Frais de port payés (€)</x-Form.Label>
                    <x-Form.Input name="shipping_fees_payed" placeholder="8" value="{{ old('shipping_fees_payed') }}"/>
                </div>
            </div>
            <div class="flex gap-4 mb-4">
                <div class="w-1/3">
                    <x-Form.Label for="date-begin" block>Date de début de la vente</x-Form.Label>
                    <x-Form.Date name="date_begin" value="{{ old('date_begin', $today) }}"/>
                </div>
                <div class="w-1/3">
                    <x-Form.Label for="date-sold" block>Date de confirmation de vente</x-Form.Label>
                    <x-Form.Date name="date_sold" value="{{ old('date_sold') }}"/>
                </div>
                <div class="w-1/3">
                    <x-Form.Label for="date-send">Date d'envoi du colis</x-Form.Label>
                    <x-Form.Date name="date_send" value="{{ old('date_send') }}"/>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <x-Form.Checkbox onChange="set_selling(this.checked);" name="add_selling">{{ strcmp(old('add_selling'), 'on') === 0 ? 'checked' : '' }}</x-Form.Checkbox>
            <x-Form.Label class="ml-1" for="add-selling">Créer & lier une vente</x-Form.Label>
        </div>
        <div class="flex items-center justify-between">
            <x-Form.Btn type="submit">Ajouter l'achat</x-Form.Btn>
            <x-Form.Cancel href="{{ route('products.show', $product->id) }}"/>
        </div>
    </form>
    </div>
@endsection