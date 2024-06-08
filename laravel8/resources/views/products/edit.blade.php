@extends('template')

@section('breadcrumbs')
    {{ Breadcrumbs::render('edit', 'product', $product) }}
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"/>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script type="text/javascript">
        document.getElementById('template-type').addEventListener('change', setTemplateType);
        function setTemplateType(){
            document.getElementById('wrap-lk-video-game').classList.add('hidden');
            document.getElementById('wrap-lk-vg-support').classList.remove('hidden');
            if(document.getElementById('template-type').value === 'video_game'){
                document.getElementById('wrap-lk-video-game').classList.remove('hidden');
            }
            if(document.getElementById('template-type').value === 'none'){
                document.getElementById('wrap-lk-vg-support').classList.add('hidden');
            }
        }
        setTemplateType();

        $('#lk-video-game').select2({
            placeholder: 'Sélectionnez un jeu vidéo...',
            ajax: {
                url: "{{ route('autocomplete') }}",
                dataType: 'json',
                delay: 200,
                data: function(params) {
                    return {
                        q: params.term,
                        page: params.page,
                        searchDataType: 'video_game'
                    };
                },
                processResults: function (data) {
                    return {
                        results:  $.map(data, function (item) {
                            return {
                                text: item.label,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });

        $('#lk-vg-support').select2({
            placeholder: 'Sélectionnez un support de jv...',
            allowClear: true,
            ajax: {
                url: "{{ route('autocomplete') }}",
                dataType: 'json',
                delay: 200,
                data: function(params) {
                    return {
                        q: params.term,
                        page: params.page,
                        searchDataType: 'vg_support'
                    };
                },
                processResults: function (data) {
                    return {
                        results:  $.map(data, function (item) {
                            return {
                                text: item.alias + ' - ' + item.label,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });
    </script>
@endsection

@section('content')
@php($template = $product->get_template())
<x-Notification type="success" msg="{{ session('info') }}"/>

<div class="min-w-full max-w-xs">
    <form id="my-form" class="bg-white rounded px-8 pt-6 pb-8 mb-4" action="{{ route('products.update', $product) }}" method="POST">
        @csrf
        @method('put')
        <div class="relative flex">
            <h1>Edition du produit</h1>
            <div class="absolute right-0 bottom-0">
                <a href="{{ route('products.create') }}" title="Créer un nouveau produit" class="title-icon cursor-pointer inline-flex">
                    <x-svg.plus class="icon-xs"/>
                </a>
            </div>
        </div>
        <hr/>
        
        <div class="flex gap-4 mb-4">
            <div class="w-2/12 flex justify-center items-center">
                <img src="{{ $product->pict }}" class="h-40"/>
            </div>
            <div class="flex flex-col w-7/12 gap-4">
                <div>
                    <x-Form.Label for="label" block required>Nom du produit</x-Form.Label>
                    <x-Form.Input name="label" placeholder="Uncharted 4" value="{{ old('label', $product->label) }}"/>
                </div>
                <div class="flex gap-4">
                    <div class="w-1/5">
                        <x-Form.Label for="template-type" block>Type du produit</x-Form.Label>
                        <select name="template_type" id="template-type" class="pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                            <option value="none">Aucun</option>
                            <option value="video_game" @if(strcmp($template->type, 'video_game') === 0) selected @endif>Jeu Vidéo</option>
                            <option value="vg_support" @if(strcmp($template->type, 'vg_support') === 0) selected @endif>Support de JV</option>
                        </select>
                        @error('lk_video_game')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @error('lk_vg_support')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    @if ($product->video_game)
                        @php($vg = $product->video_game)
                        <div class="flex inline-flex items-center gap-2 pt-6">
                            Associé à<x-svg.big.vg_controller class="icon-sm text-red-600"/>
                            <a href="{{ route('video_games.show', $vg->video_game_id) }}" class="font-bold link">{{ $vg->video_game->label.' ('.$vg->vg_support->alias.')' }}</a>
                        </div>
                    @else
                        <div id="wrap-lk-video-game" class="w-2/5">
                            <x-Form.Label for="lk-video-game" required block>Associer le jeu vidéo</x-Form.Label>
                            <select name="lk_video_game" id="lk-video-game" value="{{ old('lk_video_game') }}" class="w-full"></select>
                        </div>
                        <div id="wrap-lk-vg-support" class="w-2/5">
                            <x-Form.Label for="lk-vg-support" required block>Associer le support</x-Form.Label>
                            <select name="lk_vg_support" id="lk-vg-support" value="{{ old('lk_vg_support') }}" class="w-full"></select>
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex justify-around w-3/12 gap-4">
                <div class="flex flex-col w-1/3 gap-4">
                    <div>
                        <x-Form.Label for="limited-edition" block>Edition limitée ?</x-Form.Label>
                        <x-Form.Input name="limited_edition" placeholder="3000" value="{{ old('limited_edition', $product->limited_edition) }}"/>
                    </div>
                    <div>
                        <x-Form.Label for="real-cost" block required>Prix neuf (€)</x-Form.Label>
                        <x-Form.Input name="real_cost" placeholder="20.50" value="{{ old('real_cost', $product->real_cost) }}"/>
                    </div>
                </div>
                <div class="w-2/3">
                    <x-Form.Label for="tag-ids" block required create="{{ route('tags.create') }}">Tags associés</x-Form.Label>
                    <select multiple name="tag_ids[]" id="tag-ids" class="pl-2 h-32 block w-full rounded-md bg-gray-100 border-transparent">
                        @foreach($tags as $tag)
                            <option value="{{ $tag->id }}" @if(in_array($tag->id, old('tags_id', $product->tag_ids()))) selected @endif>{{ $tag->label }}</option>
                        @endforeach
                    </select>
                    @error('product_state_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="mb-4">
            <x-Form.Label for="description" block>Description</x-Form.Label>
            <x-Form.Textarea name="description">{{ old('description', $product->description) }}</x-Form.Textarea>
        </div>
        <div class="flex items-center justify-between">
            <x-Form.Btn type="submit">Modifier le produit</x-Form.Btn>
            <x-Form.Cancel href="{{ route('products.show', $product->id) }}"/>
        </div>
    </form>
    </div>
@endsection