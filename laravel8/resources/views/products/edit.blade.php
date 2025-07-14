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
    <script src="{{ asset('js/templates.js') }}"></script>
    <script type="text/javascript">
        initSelect2('#lk-video-game', 'Sélectionnez un jeu vidéo...', 'video_game');
        initSelect2('#lk-vg-support', 'Sélectionnez un support de jv...', 'vg_support', (item) => item.alias + ' - ' + item.label);
        initSelect2('#lk-publisher', 'Sélectionnez une maison d\'édition...', 'publisher');
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
        
        <div class="flex flex-row gap-4">
            <div class="flex flex-col w-10/12 gap-4">
                <div class="flex w-full gap-4">
                    <div class="flex flex-col items-center w-2/12">
                        <img src="{{ $product->pict }}" class="h-40"/>
                    </div>
                    <div class="flex flex-col w-7/12 gap-4">
                        <div>
                            <x-Form.Label for="label" block required>Nom du produit</x-Form.Label>
                            <x-Form.Input name="label" placeholder="Uncharted 4" value="{{ old('label', $product->label) }}"/>
                        </div>
                        <div class="flex gap-4">
                            @include('partials.products.template.edit', compact($template, ($message ?? null)))
                        </div>
                    </div>

                    <div class="flex justify-around w-3/12 gap-4">
                        <div class="flex flex-col gap-4">
                            <div>
                                <x-Form.Label for="limited-edition" block>Edition limitée ?</x-Form.Label>
                                <x-Form.Input name="limited_edition" placeholder="3000" value="{{ old('limited_edition', $product->limited_edition) }}"/>
                            </div>
                            <div>
                                <div class="relative flex inline-flex w-full">
                                    <x-Form.Label for="real-cost" block required>Prix neuf (€)</x-Form.Label>
                                    <x-Utils.Convert inputId="real-cost" onClick="updatePrices(true)"/>
                                </div>
                                <x-Form.Input name="real_cost" placeholder="20.50" value="{{ old('real_cost', $product->real_cost) }}"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full mb-4">
                    <x-Form.Label for="description" block showNbChars="description">Description</x-Form.Label>
                    <x-Form.Textarea name="description">{{ old('description', $product->description) }}</x-Form.Textarea>
                </div>
            </div>
            <div class="flex flex-col w-2/12 h-full">
                <x-Form.Label for="tag-ids" block required create="{{ route('tags.create') }}">Tags associés</x-Form.Label>
                <select multiple name="tag_ids[]" id="tag-ids" class="pl-2 h-72 block w-full rounded-md bg-gray-100 border-transparent">
                    @foreach($tags as $tag)
                        <option value="{{ $tag->id }}" @if(in_array($tag->id, old('tags_id', $product->tag_ids()))) selected @endif>{{ $tag->label }}</option>
                    @endforeach
                </select>
                @error('product_state_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        
        <div class="flex items-center justify-between">
            <x-Form.Btn type="submit">Modifier le produit</x-Form.Btn>
            <x-Form.Cancel href="{{ route('products.show', $product->id) }}"/>
        </div>
    </form>
    </div>
@endsection