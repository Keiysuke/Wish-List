@extends('template', ['kind' => 'video_game'])
@php($dir = is_null($product)? null : config('images.path_products').'/'.$product->id.'/')

@section('metas')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('absolute_content')
{{-- @include('partials.products.zoom_pictures', ['dir' => $dir, 'photos' => $photos]) --}}
@endsection

@section('breadcrumbs')
{{ Breadcrumbs::render('show', 'video_game', $video_game) }}
@endsection

@section('js')
<script type="text/javascript" src="{{ URL::asset('js/clipboard.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/my_fetch.js') }}"></script>
<script>
    function onPicture(on){
        if(on){
            document.getElementById('big_picture_zoom').classList.remove('hidden');
            document.getElementById('big_picture').classList.add('opacity-30');
        }else{
            document.getElementById('big_picture_zoom').classList.add('hidden');
            document.getElementById('big_picture').classList.remove('opacity-30');
        }
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

    document.querySelector('#fast_lk_product').addEventListener('click', () => {
        my_fetch('{{ route('vg_link_product') }}', {method: 'post', csrf: true}, {
            video_game_id: document.getElementById('video_game_id').value,
            vg_support_id: null
        }).then(response => {
            if (response.ok) return response.json();
        }).then(res => {
            console.log(res); //TODO Flash Message
            if (res.success) location.reload();
        });
    });
    
    Array.from(document.getElementsByClassName('unlink_product')).forEach(el => { el.addEventListener('click', unlinkProduct); });
    function unlinkProduct(e){
        let id = e.target.dataset.id
        my_fetch('{{ route('vg_unlink_product') }}', {method: 'post', csrf: true}, {
            id: id
        }).then(response => {
            if (response.ok) return response.json();
        }).then(res => {
            if (res.success) {
                document.querySelector('#product_link_'+id).remove()
            }
        });
    }
</script>
@endsection

@php($support = $video_game->support())
@section('content')
    <input type="hidden" id="video_game_id" value="{{ $video_game->id }}"/>
    <x-notification type="success" msg="{{ session('info') }}"/>

    <div class="relative flex justify-center border-b-2 mb-4">
        @if(!is_null($product))
            <div class="absolute left-0 flex inline-flex gap-2">
                <a title="Editer les photos" href="{{ route('product_photos.edit', $product->id) }}" class="title-icon inline-flex">
                    <x-svg.picture class="icon-xs"/>
                </a>
                <x-svg.folder class="bottom-1 cursor icon-xs" title="Copier le lien vers le dossier" onClick="setClipboard('{{ str_replace('\\', '/', public_path()).'/'.$dir }}')"/>
            </div>
        @endif
        <h1>{{ $video_game->label }}</h1>
        <div class="absolute right-0">
            <a title="Editer le jeu vidéo" href="{{ route('video_games.edit', $video_game->id) }}" class="title-icon inline-flex">
                <x-svg.edit class="icon-xs"/>
            </a>
            <x-utils.yt.title_icon search="{{ $video_game->label }} Soundtrack"/>
            <x-utils.psthc.title_icon search="{{ $video_game->label }}" support="{{ is_null($support)? 'ps4' : $support->alias }}"/>
        </div>
    </div>
    <div class="flex justify-between h-full divide-x-2 pb-12">
        @if(!is_null($product))
            <div class="w-1/5">
                <div id="product_picture" class="flex justify-center">
                    <img id="big_picture" class="pr-1" src="{{ asset($dir.$photos->first()->label) }}"/>
                </div>
            </div>
        @endif
        <div class="{{ is_null($product)? 'w-full' : 'w-4/5' }}">
            <div class="flex flex-col justify-between h-full gap-8 p-4 pt-0">
                <div class="flex gap-4 h-full">
                    <div class="flex flex-col justify-around gap-4 w-9/12">
                        <div>
                            <p class="text-lg font-semibold">Description</p>
                            <p class="text-sm ml-4 italic">{!! nl2br($video_game->description) !!}</p>
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
                            <span id="fast_lk_product" title="Association auto" class="title-icon refresh cursor-pointer inline-flex">
                                <x-svg.refresh class="icon-xs"/>
                            </span>
                            <a title="Associer un produit" href="{{ route('my_products', ['search' => $video_game->label, 'fast_search' => true]) }}" class="title-icon inline-flex">
                                <x-svg.search class="icon-xs"/>
                            </a>
                        </div>
                    </div>
                    @include('partials.video_games.list.products', $products)
                </div>
            </div>
        </div>
    </div>
@endsection