@extends('template')

@section('metas')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('create_group_buy') }}
@endsection

@section('js')
<script type="text/javascript" src="{{ URL::asset('js/my_fetch.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/groupBuys.js') }}"></script>
@endsection

@section('content')
<x-Notification type="success" msg="{{ session('info') }}"/>

<div class="min-w-full max-w-xs">
    <form class="bg-white rounded px-8 pt-6 pb-8 mb-4" action="{{ route('group_buys.store') }}" method="POST">
        @csrf
        <h1>Création d'un achat groupé</h1>
        <hr/>

        <input type="hidden" value="{{ Auth::user()->id }}" name="user_id" id="user-id"/>
        
        <div class="flex justify-center gap-4 mb-4">
            <div class="w-4/12">
                <x-Form.Label for="label" block>Nommer l'achat groupé ?</x-Form.Label>
                <x-Form.Input name="label" placeholder="Fête des pères" value="{{ old('label') }}"/>
            </div>
            {{-- <div class="w-2/12">
                <x-Form.Label for="global-cost" block required>Coût global € (sans les Fdp)</x-Form.Label>
                <x-Form.Input name="global_cost" placeholder="350" value="{{ old('global_cost') }}"/>
            </div> --}}
            <div class="w-1/12">
                <div class="relative flex inline-flex w-full">
                    <x-Form.Label for="shipping-fees" block required>Frais de port</x-Form.Label>
                    <x-Utils.Convert inputId="shipping-fees"/>
                </div>
                <x-Form.Input name="shipping_fees" placeholder="49.99" value="{{ old('shipping_fees', 0) }}"/>
            </div>
            <div class="w-1/12">
                <x-Form.Label for="discount" block>Réduction (€)</x-Form.Label>
                <x-Form.Input name="discount" placeholder="0" value="{{ old('discount', 0) }}"/>
            </div>
            <div class="w-2/12">
                <x-Form.Label for="date" block required>Date d'achat</x-Form.Label>
                <x-Form.Date name="date" value="{{ old('date') }}"/>
            </div>
        </div>

        <!-- Liste des produits-->
        <h2 class="relative">Liste des produits achetés</h2>
        <input type="hidden" id="max-nb-products" name="max_nb_products" value="{{ old('max_nb_products', 0) }}"/>
        @error('max_nb_products')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <div id="all-products-bought" class="flex flex-col gap-4 my-4">
            @for($nb = 0; $nb < old('max_nb_products', 0); $nb++)
                <!-- On trie les produits par id afin de récupérer celui correspondant à l'ancien id sélectionné -->
                @php($product = $products->keyBy('id')->get(old('product_bought_id_'.$nb, 1)))
                @include('partials.group_buy.select_product', compact('nb', 'products', 'product'))
            @endfor
        </div>

        <div class="flex gap-4 items-center mb-4">
            <select name="productNbToAdd" id="product-nb-to-add" class="pl-2 h-10 block rounded-md bg-gray-100 border-transparent">
                @for($i = 1; $i <= 10; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
            <x-Form.BtnPlus id="add-product" mb="0">Lier un produit</x-Form.BtnPlus>
        </div>

        <div class="flex items-center justify-between">
            <x-Form.Btn type="submit">Ajouter l'achat groupé</x-Form.Btn>
            <x-Form.Cancel href="{{ route('myProducts') }}"/>
        </div>
    </form>
    </div>
@endsection