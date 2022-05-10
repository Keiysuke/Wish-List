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
        document.querySelector('#template_type').addEventListener('change', set_template_type);
        function set_template_type(){
            document.querySelector('#wrap_lk_video_game').classList.add('hidden');
            document.querySelector('#wrap_lk_vg_support').classList.remove('hidden');
            if(document.querySelector('#template_type').value === 'video_game'){
                document.querySelector('#wrap_lk_video_game').classList.remove('hidden');
            }
            if(document.querySelector('#template_type').value === 'none'){
                document.querySelector('#wrap_lk_vg_support').classList.add('hidden');
            }
        }
        set_template_type();

        $('#lk_video_game').select2({
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

        $('#lk_vg_support').select2({
            placeholder: 'Sélectionnez un support de jv...',
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
                                text: item.label,
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
@php($dir = config('images.path_products').'/'.$product->id.'/')
<x-notification type="success" msg="{{ session('info') }}"/>

<div class="min-w-full max-w-xs">
    <form class="bg-white rounded px-8 pt-6 pb-8 mb-4" action="{{ route('products.update', $product) }}" method="POST">
        @csrf
        @method('put')
        <h1>Edition du produit</h1>
        <hr/>
        
        <div class="flex gap-4 mb-4">
            <div class="w-2/12 flex justify-center items-center">
                <img src="{{ asset($dir.$product->photos->firstWhere('ordered', 1)->label) }}" class="h-40"/>
            </div>
            <div class="flex flex-col w-7/12 gap-4">
                <div>
                    <x-form.label for="label" block required>Nom du produit</x-form.label>
                    <x-form.input name="label" placeholder="Uncharted 4" value="{{ old('label', $product->label) }}"/>
                </div>
                <div class="flex gap-4">
                    <div class="w-1/5">
                        <x-form.label for="template_type" block>Type du produit</x-form.label>
                        <select name="template_type" id="template_type" class="pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                            <option value="none">Aucun</option>
                            <option value="video_game" @if(strcmp($template->type, 'video_game') === 0) selected @endif>Jeu Vidéo</option>
                            <option value="vg_support" @if(strcmp($template->type, 'vg_support') === 0) selected @endif>Support de JV</option>
                        </select>
                        @error('template_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div id="wrap_lk_video_game" class="w-2/5">
                        <x-form.label for="lk_video_game" block>Associer l'existant</x-form.label>
                        <select name="lk_video_game" id="lk_video_game" value="{{ old('lk_video_game') }}" class="w-full"></select>
                    </div>
                    <div id="wrap_lk_vg_support" class="w-2/5">
                        <x-form.label for="lk_vg_support" block>Associer l'existant</x-form.label>
                        <select name="lk_vg_support" id="lk_vg_support" value="{{ old('lk_vg_support') }}" class="w-full"></select>
                    </div>
                </div>
            </div>

            <div class="flex justify-around w-3/12 gap-4">
                <div class="flex flex-col w-1/3 gap-4">
                    <div>
                        <x-form.label for="limited_edition" block>Edition limitée ?</x-form.label>
                        <x-form.input name="limited_edition" placeholder="3000" value="{{ old('limited_edition', $product->limited_edition) }}"/>
                    </div>
                    <div>
                        <x-form.label for="real_cost" block required>Prix neuf (€)</x-form.label>
                        <x-form.input name="real_cost" placeholder="20.50" value="{{ old('real_cost', $product->real_cost) }}"/>
                    </div>
                </div>
                <div class="w-2/3">
                    <x-form.label for="tag_ids" block required>Tags associés</x-form.label>
                    <select multiple name="tag_ids[]" id="tag_ids" class="pl-2 h-32 block w-full rounded-md bg-gray-100 border-transparent">
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
            <x-form.label for="description" block>Description</x-form.label>
            <x-form.textarea name="description">{{ old('description', $product->description) }}</x-form.textarea>
        </div>
        <div class="flex items-center justify-between">
            <x-form.btn type="submit">Modifier le produit</x-form.btn>
            <x-form.cancel href="{{ route('products.show', $product->id) }}"/>
        </div>
    </form>
    </div>
@endsection