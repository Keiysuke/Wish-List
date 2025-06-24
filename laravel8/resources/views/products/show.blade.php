@extends('template')
@php($dir = config('images.path_products').'/'.$product->id.'/')

@section('metas')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('absolute_content')
    @include('partials.products.zoom_pictures', ['dir' => $dir, 'photos' => $photos, 'firstPhoto' => $product->pict])
    @include('partials.products.my_lists', ['id' => $product->id, 'product_id' => $product->id])
    <div id="content-share-product" class="hidden">
    </div>
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
<script type="text/javascript" src="{{ URL::asset('js/products.js') }}"></script>
<script>
    let cur_pict = 1;
    if (document.getElementById('nb-max-pict').value > 1) {
        setInterval(() => {
            changePictures();
        }, 4000);
    }

    window.onload = function(){
        //Flip thumbnails if some are in a selling's state
        Array.from(document.getElementsByClassName('recto-side flip_thumbnail')).forEach(el => {
            el.onclick();
        });
    }
</script>
@endsection

@section('content')
    <input type="hidden" id="product-id" value="{{ $product->id }}"/>
    <x-Notification type="success" msg="{{ session('info') }}"/>
    
    <div class="relative flex justify-center border-b-2 mb-4">
        <div class="absolute left-0 flex inline-flex gap-1">
            <a title="Editer les photos" href="{{ route('productPhotos.edit', $product->id) }}" class="title-icon inline-flex">
                <x-svg.picture class="icon-xs"/>
            </a>
            <x-products.search_photo id="icon-find-photo" search="{{ $product->label }}" class="title-icon inline-flex"/>
            <x-svg.folder class="bottom-1 ml-1 cursor icon-xs" title="Copier le lien vers le dossier" onClick="setClipboard('{{ str_replace('\\', '/', public_path()).'/'.$dir }}')"/>
        </div>
        <h1>{{ $product->label }}</h1>
        <div class="absolute right-0">
            @if($product->video_game)
                <x-Utils.TitleIcon.Vg id="{{ $product->video_game->video_game_id }}"/>
            @endif
            @if($product->created)
                <a title="Editer le produit" href="{{ route('products.edit', $product->id) }}" class="title-icon inline-flex">
                    <x-svg.edit class="icon-xs"/>
                </a>
            @endif
            <span title="Ajouter à une liste" id="add-to-list" class="title-icon add_to_list cursor-pointer inline-flex" onClick="toggleShowLists();">
                <x-svg.add_to_list class="icon-xs"/>
            </span>
            <span title="{{ $product->following? 'Ne plus suivre' : 'Suivre le produit' }}" id="follow-product" class="title-icon heart {{ $product->following? 'on' : '' }} cursor-pointer inline-flex">
                <x-svg.heart class="icon-xs"/>
            </span>
            <span class="title-icon cursor-pointer inline-flex ml-1" onClick="showShare({{ $product->id }}, 'product');">
                <x-svg.share title="Partager le produit ?" class="icon-xs"/>
            </span>
            <span title="{{ $product->archived? 'Retirer des archives' : 'Archiver le produit' }}" id="archive-product" class="title-icon archive {{ $product->archived? 'on' : '' }} cursor-pointer inline-flex">
                <x-svg.archive class="icon-xs"/>
            </span>
        </div>
    </div>
    <div class="flex justify-between h-full divide-x-2 {{ (count($purchases) > 0 && session()->has('info'))? 'pb-32' : 'pb-12' }}">
        <div class="{{ (count($photos) > 1)? 'w-1/3' : 'w-1/4' }}">
            @include('partials.products.list.pictures', [$photos, 'dir' => $dir, 'firstPhoto' => $product->pict])
        </div>
        <div class="{{ (count($photos) > 1)? 'w-2/3' : 'w-3/4' }}">
            <div class="flex flex-col justify-between h-full gap-8 pl-4 pt-0">
                <div class="flex gap-4 h-full">
                    <div class="flex flex-col justify-around gap-4 w-9/12">
                        <div>
                            @if($product->book)
                                <p class="text-lg"><b>Maison d'édition :</b> {!! $product->book->getPublisherAsLink() !!}
                            @endif
                            <p class="text-lg font-semibold">Description</p>
                            <p class="text-sm ml-4 italic">{!! nl2br($product->description) !!}</p>
                        </div>
                        <div class="flex inline-flex gap-2">
                            @foreach($product->tags as $tag)
                                <x-Tags.Tag :tag="$tag"/>
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
                            <a title="Lier un site de vente" href="{{ route('productWebsites.create', $product->id) }}" class="title-icon inline-flex">
                                <x-svg.plus class="icon-xs"/>
                            </a>
                            <x-products.search_offer id="icon-find-offer" search="{{ $product->label }}"/>
                            @if($product->isBook())
                                <x-products.search_opinion id="icon-find-opinion" search="{{ $product->label }}"/>
                            @endif
                            @if($productWebsites->nb_expired > 0)
                                <span class="title-icon inline-flex cursor-pointer" title="Afficher les liens expirés" onClick="showExpired(this);">
                            @else
                                <span class="title-icon disabled inline-flex" title="Aucun lien n'a expiré pour ce produit">
                            @endif
                                <input id="show-expired" value="hide" type="hidden"/>
                                <x-svg.eye_open id="icon-show-expired" class="icon-xs {{ $productWebsites->nb_expired > 0 ? '' : 'disabled' }}"/>
                                <x-svg.eye_close id="icon-hide-expired" class="icon-xs hidden"/>
                            </span>
                        </div>
                    </div>
                    @include('partials.products.list.websites', $productWebsites)
                </div>
                <div class="h-full">
                    <div class="flex justify-between border-b-2 mb-4">
                        <div class="flex align-start gap-1">
                            <x-svg.big.idea class="w-7"/>
                            <h2>Projets participatifs associés :</h2>
                        </div>
                        <a title="Ajouter un projet" href="{{ route('products.crowdfundings.create', $product->id) }}" class="title-icon inline-flex">
                            <x-svg.plus class="icon-xs"/>
                        </a>
                    </div>
                    @include('partials.products.list.crowdfundings', ['product' => $product])
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