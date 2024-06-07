@extends('template', ['kind' => 'video_game'])
@php($dir = is_null($product)? null : config('images.path_products').'/'.$product->id.'/')

@section('metas')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('absolute_content')
{{-- @include('partials.products.zoom_pictures', ['dir' => $dir, 'photos' => $photos]) --}}
@endsection

@section('breadcrumbs')
{{ Breadcrumbs::render('show', 'video_game', $videoGame) }}
@endsection

@section('js')
<script type="text/javascript" src="{{ URL::asset('js/clipboard.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/my_fetch.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/my_notyf.js') }}"></script>
<script>
    function onPicture(on){
        if(on){
            document.getElementById('big-img-zoom').classList.remove('hidden');
            document.getElementById('big-img').classList.add('opacity-30');
        }else{
            document.getElementById('big-img-zoom').classList.add('hidden');
            document.getElementById('big-img').classList.remove('opacity-30');
        }
    }
    
    function showPict(i){
        event.stopPropagation();
        document.getElementById('img-zoom-main').setAttribute('src', document.getElementById('img-zoom-sec'+i).getAttribute('src'));
    }
    
    function toggleZoomPictures(i = 1){
        event.stopPropagation();
        document.getElementById('img-zoom-main').setAttribute('src', document.getElementById('img-zoom-sec'+i).getAttribute('src'));
        document.getElementById('content-img-zoomed').classList.toggle('hidden');
        document.getElementById('main').classList.toggle('pointer-events-none');
    }

    document.getElementById('fast-link-product').addEventListener('click', () => {
        const vgId = document.getElementById('video-game-id').value;
        getFetch('video_games/' + vgId + '/vg_support/0/products/link')
        .then(res => {
            my_notyf(res);
            if (res.success) location.reload();
        });
    });
    
    Array.from(document.getElementsByClassName('unlink-product')).forEach(el => { el.addEventListener('click', unlinkProduct); });
    function unlinkProduct(e){
        let productId = e.target.dataset.id
        getFetch('video_games/products/' + productId + '/unlink')
        .then(res => {
            if (res.success) {
                my_notyf(res);
                document.getElementById('product-link-'+productId).remove()
            }
        });
    }
</script>
@endsection

@php($support = $videoGame->support())
@section('content')
    <input type="hidden" id="video-game-id" value="{{ $videoGame->id }}"/>
    <x-Notification type="success" msg="{{ session('info') }}"/>

    <div class="relative flex justify-center border-b-2 mb-4">
        @if(!is_null($product))
            <div class="absolute left-0 flex inline-flex gap-1">
                <a title="Editer les photos" href="{{ route('productPhotos.edit', $product->id) }}" class="title-icon inline-flex">
                    <x-svg.picture class="icon-xs"/>
                </a>
                <x-svg.folder class="bottom-1 ml-1 cursor icon-xs" title="Copier le lien vers le dossier" onClick="setClipboard('{{ str_replace('\\', '/', public_path()).'/'.$dir }}')"/>
            </div>
        @endif
        <h1>{{ $videoGame->label }}</h1>
        <div class="absolute right-0">
            <a title="Editer le jeu vidéo" href="{{ route('video_games.edit', $videoGame->id) }}" class="title-icon inline-flex">
                <x-svg.edit class="icon-xs"/>
            </a>
            <x-Utils.Yt.TitleIcon search="{{ $videoGame->label }} Soundtrack"/>
            <x-Utils.Psthc.TitleIcon search="{{ $videoGame->label }}" support="{{ is_null($support)? 'ps4' : $support->alias }}"/>
        </div>
    </div>
    <div class="flex justify-between h-full divide-x-2 pb-12">
        @if(!is_null($product))
            <div class="w-1/5">
                <div id="product-picture" class="flex justify-center">
                    <img id="big-img" class="pr-1" src="{{ asset($dir.$photos->first()->label) }}"/>
                </div>
            </div>
        @endif
        <div class="{{ is_null($product)? 'w-full' : 'w-4/5' }}">
            <div class="flex flex-col justify-between h-full gap-8 p-4 pt-0">
                <div class="flex gap-4 h-full">
                    <div class="flex flex-col justify-around gap-4 w-9/12">
                        <div>
                            <p class="text-lg font-semibold">Description</p>
                            <p class="text-sm ml-4 italic">{!! nl2br($videoGame->description) !!}</p>
                        </div>
                    </div>
                </div>
                <div class="h-full">
                    <div class="relative flex justify-between border-b-2 mb-4">
                        <div class="flex align-start gap-1">
                            <x-svg.big.shop_bag class="w-7"/>
                            <h2>Produits associées :</h2>
                        </div>
                        <div class="absolute right-0 -top-1">
                            <span id="fast-link-product" title="Association auto" class="title-icon refresh cursor-pointer inline-flex">
                                <x-svg.refresh class="icon-xs"/>
                            </span>
                            <a title="Rechercher un produit" href="{{ route('myProducts', ['search' => $videoGame->label, 'fast_search' => true]) }}" class="title-icon inline-flex">
                                <x-svg.big.circle_search class="icon-xs"/>
                            </a>
                            <x-products.search_offer id="icon-find-offer" search="{{ $videoGame->label }}"/>
                        </div>
                    </div>
                    @include('partials.video_games.list.products', $products)
                </div>
            </div>
        </div>
    </div>
@endsection