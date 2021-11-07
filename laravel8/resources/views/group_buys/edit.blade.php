@extends('template')

@section('metas')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('edit_group_buy', $group_buy) }}
@endsection

@section('js')
<script type="text/javascript" src="{{ URL::asset('js/my_fetch.js') }}"></script>
<script>
    document.querySelector('#add_product').addEventListener('click', get_products);
    setListeners();

    function setListeners(){
        for(const el of document.getElementsByClassName('product_bought')) el.addEventListener('change', handle_product_change);
        for(const el of document.getElementsByClassName('dynamic_select_data')) el.addEventListener('change', set_select_data);
    }

    function set_select_data(){
        const e = this;
        for(const opt of e.options) {
            if(e.value == opt.value) document.getElementById(e.id+'_'+opt.value).setAttribute('selected', 'selected');
            else document.getElementById(e.id+'_'+opt.value).removeAttribute('selected');
        }
    }

    function get_products(event){ //Ajoute un nouveau produit sélectionnable pour l'achat groupé
        event.preventDefault();
        my_fetch('{{ route('group_buys.get_products') }}', {method: 'post', csrf: true}, {
            nb: document.querySelector('#max_product_nb').value++,
            user_id: document.querySelector('#user_id').value,
        }).then(response => {
            if (response.ok) return response.json();
        }).then(res => {
            document.getElementById('all_products_bought').innerHTML += res.html;
        }).then(() => {
            setListeners();
        });
    }
    
    function handle_product_change(event){ //Met à jour l'affichage lorsque l'on sélectionne un produit dans la liste
        event.preventDefault();
        const product_id = event.target.value;
        const nb = event.target.dataset.nb;
        my_fetch('{{ route('products.get_picture') }}', {method: 'post', csrf: true}, {
            product_id: event.target.value,
        }).then(response => {
            if (response.ok) return response.json();
        }).then(res => {
            document.getElementById('product_bought_img_'+nb).src = res.html;
        })
        
        get_product_datas(product_id, nb);
    }

    function handle_existing_buy(e, nb){ //Gère le moment où l'on affiche/ou non, un achat existant
        if(e.checked){
            document.getElementById('product_bought_existing_'+nb).setAttribute('checked', true);
            document.getElementById('product_bought_purchase_'+nb).classList.remove('hidden');
            document.getElementById('product_bought_offer_'+nb).classList.add('hidden');
            document.getElementById('div_product_bought_nb_'+nb).classList.add('hidden');
            document.getElementById('product_bought_discount_'+nb).classList.add('hidden');
            document.getElementById('product_bought_customs_'+nb).classList.add('hidden');
        }else{
            document.getElementById('product_bought_existing_'+nb).removeAttribute('checked');
            document.getElementById('product_bought_purchase_'+nb).classList.add('hidden');
            document.getElementById('product_bought_offer_'+nb).classList.remove('hidden');
            document.getElementById('div_product_bought_nb_'+nb).classList.remove('hidden');
            document.getElementById('product_bought_discount_'+nb).classList.remove('hidden');
            document.getElementById('product_bought_customs_'+nb).classList.remove('hidden');
        }
    }

    function get_product_datas(product_id, nb){ //Récupère les données (offres, achats existants) du produit passé
        my_fetch('{{ route('group_buys.get_product_datas') }}', {method: 'post', csrf: true}, {
            product_id: product_id,
            nb: nb,
        }).then(response => {
            if (response.ok) return response.json();
        }).then(res => {
            document.getElementById('product_bought_offer_'+nb).innerHTML = res.html.offers;
            document.getElementById('product_bought_purchase_'+nb).innerHTML = res.html.purchases;
        }).then(() => {
            setListeners();
        });
    }
</script>
@endsection

@section('content')
<x-notification type="success" msg="{{ session('info') }}"/>

<div class="min-w-full max-w-xs">
    <form class="bg-white rounded px-8 pt-6 pb-8 mb-4" action="{{ route('group_buys.update', $group_buy) }}" method="POST">
        @csrf
        @method('put')
        <div class="relative flex">
            <h1>Edition d'un achat groupé</h1>
            <div class="absolute right-0 bottom-0">
                <a href="{{ route('group_buys.destroy', $group_buy->id) }}" title="Supprimer l'achat groupé" class="title-icon heart cursor-pointer inline-flex" onClick="return confirm('Supprimer l\'achat groupé ?');">
                    <x-svg.trash class="icon-xs"/>
                </a>
            </div>
        </div>
        <hr/>

        <input type="hidden" value="{{ Auth::user()->id }}" name="user_id" id="user_id"/>
        
        <div class="flex justify-center gap-4 mb-4">
            <div class="w-4/12">
                <x-form.label for="label" block>Nommer l'achat groupé ?</x-form.label>
                <x-form.input name="label" placeholder="Fête des pères" value="{{ old('label', $group_buy->label) }}"/>
            </div>
            {{-- <div class="w-2/12">
                <x-form.label for="global_cost" block required>Coût global € (sans les Fdp)</x-form.label>
                <x-form.input name="global_cost" placeholder="350" value="{{ old('global_cost', $group_buy->global_cost) }}"/>
            </div> --}}
            <div class="w-1/12">
                <x-form.label for="shipping_fees" block required>Frais de port</x-form.label>
                <x-form.input name="shipping_fees" placeholder="49.99" value="{{ old('shipping_fees', $group_buy->shipping_fees) }}"/>
            </div>
            <div class="w-1/12">
                <x-form.label for="discount" block>Réduction (€)</x-form.label>
                <x-form.input name="discount" placeholder="0" value="{{ old('discount', $group_buy->discount) }}"/>
            </div>
            <div class="w-2/12">
                <x-form.label for="date" block required>Date d'achat</x-form.label>
                <x-form.date name="date" value="{{ old('date', $group_buy->date) }}"/>
            </div>
        </div>

        <!-- Liste des produits-->
        <h2 class="relative">Liste des produits achetés</h2>
        <input type="hidden" id="max_product_nb" name="max_product_nb" value="{{ old('max_product_nb', count($group_buy->group_buy_purchases)) }}"/>
        @error('max_product_nb')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <div id="all_products_bought" class="flex flex-col gap-4 my-4">
            @php($prev_product_id = null)
            @for($nb = 0; $nb < old('max_product_nb', count($group_buy->group_buy_purchases)); $nb++)
                <!-- On trie les produits par id afin de récupérer celui correspondant à l'ancien id sélectionné -->
                @php($product = $products->keyBy('id')->get(old('product_bought_id_'.$nb, $group_buy->group_buy_purchases->skip($nb)->first()->purchase->product_id)))
                <!-- S'il s'agit d'un produit différent, on repart du 1er achat pour celui-ci -->
                @if(is_null($prev_product_id) || $product->id != $prev_product_id)
                    @php($prev_product_id = $product->id)
                    @php($skip_purchase = 0)
                @endif
                @php($edit_purchase = $product->purchases->whereIn('id', $group_buy->datas['purchases_id'])->skip($skip_purchase++)->first())
                @include('partials.group_buy.select_product', compact('nb', 'products', 'product', 'edit_purchase'))
            @endfor
        </div>

        <x-form.btn_plus id="add_product">Lier un produit</x-form.btn_plus>

        <div class="flex items-center justify-between">
            <x-form.btn type="submit">Editer l'achat groupé</x-form.btn>
            <x-form.cancel href="{{ route('user_historic', 'purchases') }}"/>
        </div>
    </form>
    </div>
@endsection