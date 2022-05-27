@extends('template')

@section('breadcrumbs')
    {{ Breadcrumbs::render('create', 'product') }}
@endsection

@section('js')
<script>
    function set_purchase(v){
        document.getElementById('section_product_website').classList.toggle('hidden');
        document.getElementById('section_product_website').classList.toggle('block');
        document.getElementById('section_purchase').classList.toggle('hidden');
        document.getElementById('section_purchase').classList.toggle('block');
    }
    
    var loadFile = function(event) {
        URL.revokeObjectURL(event.target.files[0]);
        document.getElementById('img').src = URL.createObjectURL(event.target.files[0]);
    };
</script>
@endsection

@section('content')
<x-notification type="success" msg="{{ session('info') }}"/>

<div class="min-w-full max-w-xs">
    <form class="bg-white rounded px-8 pt-6 pb-8 mb-4" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Formulaire du produit -->
        <h1>Ajout de produit</h1>
        <hr/>

        <input type="hidden" value="{{ Auth::user()->id }}" name="user_id" id="user_id"/>
        <div class="flex gap-4">
            <div class="flex flex-col items-center w-2/12">
                <input type="file" accept="image/*" id="photo_1" name="photo_1" class="hidden" onchange="loadFile(event)">
                <div class="inline-flex">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    <label class="custom-file-label cursor-pointer" for="photo_1" data-browse="Parcourir">Choisissez une image <span class="required">*</span></label>
                </div>
                <label for="photo_1" class="cursor-pointer"><img id="img" class="border max-w-20 max-h-32" src="{{ asset('resources/images/no_pict.png') }}"/></label>
                @error('photo_1')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="flex flex-col w-7/12 gap-4">
                <div>
                    <x-form.label for="label" block required>Nom du produit</x-form.label>
                    <x-form.input name="label" placeholder="Uncharted 4" value="{{ old('label') }}"/>
                </div>
                <div class="flex gap-4">
                    <div class="w-1/5">
                        <x-form.label for="template_type" block>Type du produit</x-form.label>
                        <select name="template_type" id="template_type" class="pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                            <option value="none">Aucun</option>
                            <option value="video_game" @if(strcmp(old('template_type'), 'video_game') === 0) selected @endif>Jeu Vidéo</option>
                            <option value="vg_support" @if(strcmp(old('template_type'), 'vg_support') === 0) selected @endif>Support de JV</option>
                        </select>
                        @error('template_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-4/5">
                        <x-form.label for="product_type_linked" block>Associer avec l'existant</x-form.label>
                        <x-form.input name="product_type_linked" placeholder="Commencez à saisir le nom..." value="{{ old('product_type_linked') }}"/>
                    </div>
                </div>
            </div>

            <div class="flex justify-around w-3/12 gap-4">
                <div class="flex flex-col w-1/3 gap-4">
                    <div>
                        <x-form.label for="limited_edition" block>Edition limitée ?</x-form.label>
                        <x-form.input name="limited_edition" placeholder="3000" value="{{ old('limited_edition') }}"/>
                    </div>
                    <div>
                        <x-form.label for="real_cost" block required>Prix neuf (€)</x-form.label>
                        <x-form.input name="real_cost" placeholder="20.50" value="{{ old('real_cost') }}"/>
                    </div>
                </div>
                <div class="w-2/3">
                    <x-form.label for="tag_ids" block required create="{{ route('tags.create') }}">Tags associés</x-form.label>
                    <select multiple name="tag_ids[]" id="tag_ids" class="pl-2 h-32 block w-full rounded-md bg-gray-100 border-transparent">
                        @foreach($tags as $tag)
                            <option value="{{ $tag->id }}" @if(in_array($tag->id, old('tags_id', []))) selected @endif>{{ $tag->label }}</option>
                        @endforeach
                    </select>
                    @error('product_state_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="my-4">
            <x-form.label for="description" block>Description</x-form.label>
            <x-form.textarea name="description">{{ old('description') }}</x-form.textarea>
        </div>
        
        <!-- Formulaire liaison de site de vente au produit -->

        <div id="section_product_website" class="{{ strcmp(old('add_purchase'), 'on') === 0 ? 'block' : 'hidden' }}">
            <h1 class="text-orange-500">Pouvant être acheté sur</h1>
            <hr class="border-orange-500"/>
            
            <div class="flex gap-4">
                <div class="w-1/2">
                    <x-form.label for="website_id" block required create="{{ route('websites.create') }}">Site de vente</x-form.label>
                    <select name="website_id" id="website_id" class="pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                        @foreach($websites as $website)
                            <option value="{{ $website->id }}" @if(old('website_id') == $website->id) selected @endif>{{ $website->label }}</option>
                        @endforeach
                    </select>
                    @error('website_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="flex justify-around gap-4 w-1/2">
                    <div class="w-1/2">
                        <x-form.label for="price" block required>Prix du site (€)</x-form.label>
                        <x-form.input name="price" placeholder="50" value="{{ old('price') }}"/>
                    </div>
                    <div class="w-1/2">
                        <x-form.label for="expiration_date" block>Date d'expiration</x-form.label>
                        <x-form.date name="expiration_date" value="{{ old('expiration_date') }}"/>
                    </div>
                </div>
            </div>
            <div class="my-4">
                <x-form.label for="url" block>Url</x-form.label>
                <x-form.input name="url" placeholder="http://Amazon.fr" value="{{ old('url') }}"/>
            </div>
        </div>
        
        <!-- Formulaire d'achat -->
        
        <div id="section_purchase" class="{{ strcmp(old('add_purchase'), 'on') === 0 ? 'block' : 'hidden' }}">
            <h1 class="text-red-500">Données sur l'achat effectué</h1>
            <hr class="border-red-500"/>
            
            <div class="flex gap-4 mb-4">
                <div class="flex justify-around gap-4 w-1/2">
                    <div class="w-1/2">
                        <x-form.label for="product_state_id" block required create="{{ route('states.products.create') }}">Etat du produit</x-form.label>
                        <select name="product_state_id" id="product_state_id" class="pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                            @foreach($product_states as $product_state)
                                <option value="{{ $product_state->id }}" @if(old('product_state_id') == $product_state->id) selected @endif>{{ $product_state->label }}</option>
                            @endforeach
                        </select>
                        @error('product_state_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-1/2">
                        <x-form.label for="cost" block required>Coût (€)</x-form.label>
                        <x-form.input name="cost" type="text" placeholder="Ce produit m'a coûté..." value="{{ old('cost') }}"/>
                    </div>
                </div>
                <div class="flex justify-around gap-4 w-1/2">
                    <div class="w-1/4">
                        <x-form.label for="discount" block required>Réduction (€)</x-form.label>
                        <x-form.input name="discount" type="text" placeholder="0" value="{{ old('discount', 0) }}"/>
                    </div>
                    <div class="w-1/4">
                        <x-form.label for="customs" block required>Douane (€)</x-form.label>
                        <x-form.input name="customs" type="text" placeholder="0" value="{{ old('customs', 0) }}"/>
                    </div>
                    <div class="w-2/4">
                        <x-form.label for="date" block required>Date d'achat</x-form.label>
                        <x-form.date name="date" type="date" value="{{ old('date') }}"/>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <x-form.checkbox onChange="set_purchase(this.checked);" name="add_purchase">{{ strcmp(old('add_purchase'), 'on') === 0 ? 'checked' : '' }}</x-form.checkbox>
            <x-form.label class="ml-1" for="add_purchase">Créer & lier un achat</x-form.label>
        </div>
        <div class="flex items-center justify-between">
            <x-form.btn type="submit">Ajouter le produit</x-form.btn>
            <x-form.cancel href="{{ route('products.index') }}"/>
        </div>
    </form>
    </div>
@endsection