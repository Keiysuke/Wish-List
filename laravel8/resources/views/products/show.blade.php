@extends('template')
@php($dir = config('images.path_products').'/'.$product->id.'/')

@section('metas')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('absolute_content')
    @include('partials.products.zoom_pictures', ['dir' => $dir, 'photos' => $photos])
    @include('partials.products.my_lists', ['id' => $product->id, 'product_id' => $product->id])
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('show', 'product', $product) }}
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ url('/css/recto_verso.css') }}">
@endsection
@section('js')
<script type="text/javascript" src="{{ URL::asset('js/clipboard.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/my_fetch.js') }}"></script>
<script>
    window.onload = function(){
        //Flip thumbnails if some are in a selling's state
        Array.from(document.getElementsByClassName('recto-side flip_thumbnail')).forEach(el => {
            el.onclick();
        });
    }
    
    function toggle_thumbnail(id){
        document.getElementById('thumbnail_'+id).classList.toggle('mode-recto');
        document.getElementById('thumbnail_'+id).classList.toggle('mode-verso');
    }
    
    function onPicture(on){
        if(on){
            document.getElementById('big_picture_zoom').classList.remove('hidden');
            document.getElementById('big_picture').classList.add('opacity-30');
        }else{
            document.getElementById('big_picture_zoom').classList.add('hidden');
            document.getElementById('big_picture').classList.remove('opacity-30');
        }
    }

    function showExpired(e){
        let inp = document.getElementById('show_expired');
        if(inp.value === 'hide'){
            document.getElementById('show_expired').value = 'show';
            e.title = 'Cacher les liens expirés';
        }else{
            document.getElementById('show_expired').value = 'hide';
            e.title = 'Afficher les liens expirés';
        }
        Array.from(document.getElementsByClassName('li_website expired')).forEach(el => {
            el.classList.toggle('hidden');
        });
        document.getElementById('icon_show_expired').classList.toggle('hidden');
        document.getElementById('icon_hide_expired').classList.toggle('hidden');
    }

    function showPict(i){
        event.stopPropagation();
        document.getElementById('pict_zoom_main').setAttribute('src', document.getElementById('pict_zoom_sec_'+i).getAttribute('src'));
    }

    function toggleZoomPictures(i = 1){
        event.stopPropagation();
        document.getElementById('pict_zoom_main').setAttribute('src', document.getElementById('pict_zoom_sec_'+i).getAttribute('src'));
        document.getElementById('content_picture_zoomed').classList.toggle('hidden');
        document.getElementById('main').classList.toggle('pointer-events-none');
    }

    document.querySelector('#follow_product').addEventListener('click', () => {
        my_fetch('{{ route('follow_product') }}', {method: 'post', csrf: true}, {
            id: document.getElementById('product_id').value
        }).then(response => {
            if (response.ok) return response.json();
        }).then(res => {
            document.querySelector('#follow_product').setAttribute('title', res.product.follow? 'Ne plus suivre' : 'Suivre');
            document.querySelector('#follow_product').classList.toggle('on');
        });
    });

    document.querySelector('#archive_product').addEventListener('click', () => {
        my_fetch('{{ route('archive_product') }}', {method: 'post', csrf: true}, {
            id: document.getElementById('product_id').value
        }).then(response => {
            if (response.ok) return response.json();
        }).then(res => {
            document.querySelector('#archive_product').setAttribute('title', res.product.archived? 'Retirer des archives' : 'Archiver');
            document.querySelector('#archive_product').classList.toggle('on');
        });
    });

    //Lists Functions
    function toggleShowLists(){
        event.stopPropagation();
        document.getElementById('add_to_list').classList.toggle('hidden');
        document.getElementById('main').classList.toggle('pointer-events-none');
    }

    function toggle_list(list_id, product_id, change_checked = true){
        my_fetch('{{ route('toggle_product_on_list') }}', {method: 'post', csrf: true}, {
            list_id: list_id,
            product_id: product_id,
            nb: document.querySelector('#list_nb_'+list_id).value,
            change_checked:change_checked
        });
    }

    function simulate_benef(payed, sold) {
        if (!document.querySelector('#left_sidebar_help').classList.contains('open')) {
            document.querySelector('#icon-help').dispatchEvent(new CustomEvent('click'));
        }
        document.querySelector('#ls_benefit_payed').value = payed;
        document.querySelector('#ls_benefit_sold').value = sold;
    }
</script>
@endsection

@section('content')
    <input type="hidden" id="product_id" value="{{ $product->id }}"/>
    <x-notification type="success" msg="{{ session('info') }}"/>
    
    <div class="relative flex justify-center border-b-2 mb-4">
        <x-svg.folder class="absolute left-0 bottom-1 cursor icon-xs" title="Copier le lien vers le dossier" onClick="setClipboard('{{ str_replace('\\', '/', public_path()).'/'.$dir }}')"/>
        <h1>{{ $product->label }}</h1>
        <div class="absolute right-0">
            @if($product->created)
                <a title="Editer le produit" href="{{ route('products.edit', $product->id) }}" class="title-icon inline-flex">
                    <x-svg.edit class="icon-xs"/>
                </a>
                <a title="Editer les photos" href="{{ route('product_photos.edit', $product->id) }}" class="title-icon inline-flex">
                    <x-svg.picture class="icon-xs"/>
                </a>
            @endif
            <span title="Ajouter à une liste" id="add_to_list" class="title-icon add_to_list cursor-pointer inline-flex" onClick="toggleShowLists();">
                <x-svg.add_to_list class="icon-xs"/>
            </span>
            <span title="{{ $product->following? 'Ne plus suivre' : 'Suivre le produit' }}" id="follow_product" class="title-icon heart {{ $product->following? 'on' : '' }} cursor-pointer inline-flex">
                <x-svg.heart class="icon-xs"/>
            </span>
            <span title="{{ $product->archived? 'Retirer des archives' : 'Archiver le produit' }}" id="archive_product" class="title-icon archive {{ $product->archived? 'on' : '' }} cursor-pointer inline-flex">
                <x-svg.archive class="icon-xs"/>
            </span>
        </div>
    </div>
    <div class="flex justify-between h-full divide-x-2 {{ (count($purchases) > 0 && session()->has('info'))? 'pb-32' : 'pb-12' }}">
        <div class="{{ (count($photos) > 1)? 'w-1/3' : 'w-1/4' }}">
            @include('partials.products.list.pictures', [$photos, 'dir' => $dir])
        </div>
        <div class="{{ (count($photos) > 1)? 'w-2/3' : 'w-3/4' }}">
            <div class="flex flex-col justify-between h-full gap-8 p-4 pt-0">
                <div class="flex gap-4 h-full">
                    <div class="flex flex-col justify-around gap-4 w-9/12">
                        <div>
                            <p class="text-lg font-semibold">Description</p>
                            <p class="text-sm ml-4 italic">{!! nl2br($product->description) !!}</p>
                        </div>
                        <div class="flex inline-flex gap-2">
                            @foreach($product->tags as $tag)
                                <x-tags.tag :tag="$tag"/>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex flex-col w-3/12 justify-center items-center gap-8 text-2xl font-semibold">
                        <p class="font-medium text-lg">Edition limitée : <span class="font-normal text-sm">{{ is_null($product->limited_edition)? 'Non' : $product->limited_edition }}</span></p>
                        <div class="flex flex-col">
                            Prix neuf
                            <span class="text-blue-500">{{ $product->real_cost }} €</span>
                        </div>
                    </div>
                </div>
                <div class="h-full">
                    <div class="relative flex justify-between border-b-2 mb-4">
                        <div class="flex align-start gap-1">
                            <x-svg.big.cart class="w-7"/>
                            <h2>Offres recensées :</h2>
                        </div>
                        
                        <div class="absolute right-0 -top-1">
                            <a title="Lier un site de vente" href="{{ route('product_websites.create', $product->id) }}" class="title-icon inline-flex">
                                <x-svg.plus class="icon-xs"/>
                            </a>
                            @if($product_websites->nb_expired > 0)
                            <span class="title-icon inline-flex cursor-pointer" title="Afficher les liens expirés" onClick="showExpired(this);">
                            @else
                            <span class="title-icon disabled inline-flex" title="Aucun lien n'a expiré pour ce produit">
                            @endif
                                <input id="show_expired" value="hide" type="hidden"/>
                                <x-svg.eye_open id="icon_show_expired" class="icon-xs {{ $product_websites->nb_expired > 0 ? '' : 'disabled' }}"/>
                                <x-svg.eye_close id="icon_hide_expired" class="icon-xs hidden"/>
                            </span>
                        </div>
                    </div>
                    @include('partials.products.list.websites', $product_websites)
                </div>
                <div class="h-full">
                    <div class="flex justify-between border-b-2 mb-4">
                        <div class="flex align-start gap-1">
                            <x-svg.big.truck class="w-7"/>
                            <h2>Mes achats & ventes associées :</h2>
                        </div>
                        <a title="Ajouter un achat" href="{{ route('purchases.create', $product->id) }}" class="title-icon inline-flex">
                            <x-svg.plus class="icon-xs"/>
                        </a>
                    </div>
                    @include('partials.products.list.purchases', $purchases)
                </div>
            </div>
        </div>
    </div>
@endsection