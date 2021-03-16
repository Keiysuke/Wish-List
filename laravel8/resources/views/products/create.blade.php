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
            <div class="w-1/2">
                <label class="block text-gray-600 text-sm font-semibold mb-2" for="label">Nom du produit <span class="required">*</span></label>
                <input class="bg-gray-100 appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="label" id="label" type="text" placeholder="Uncharted 4" value="{{ old('label') }}"/>
                @error('label')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="flex justify-around w-1/2 gap-4">
                <div class="w-1/3">
                    <label class="block text-gray-600 text-sm font-semibold mb-2" for="limited_edition">Edition limitée ?</label>
                    <input class="bg-gray-100 appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="limited_edition" id="limited_edition" type="text" placeholder="3000" value="{{ old('limited_edition') }}"/>
                    @error('limited_edition')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="w-1/3">
                    <label class="block text-gray-600 text-sm font-semibold mb-2" for="real_cost">Prix neuf (€) <span class="required">*</span></label>
                    <input class="bg-gray-100 appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="real_cost" id="real_cost" type="text" placeholder="20.50" value="{{ old('real_cost') }}"/>
                    @error('real_cost')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="flex flex-col items-center w-1/3">
                    <input type="file" accept="image/*" id="photo_1" name="photo_1" class="hidden" onchange="loadFile(event)">
                    <div class="inline-flex">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        <label class="custom-file-label cursor-pointer" for="photo_1" data-browse="Parcourir">Choisissez une image <span class="required">*</span></label>
                    </div>
                    <label for="photo_1" class="cursor-pointer"><img id="img" class="border w-20" src="https://place-hold.it/80x60"/></label>
                    @error('photo_1')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="my-4">
            <label class="block text-gray-600 text-sm font-semibold mb-2" for="description">Description <span class="required">*</span></label>
            <textarea rows="4" cols="50" class="bg-gray-100 p-1 appearance-none border rounded w-full text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="description" id="description" type="text"/>{{ old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <!-- Formulaire liaison de site de vente au produit -->

        <div id="section_product_website" class="{{ strcmp(old('add_purchase'), 'on') === 0 ? 'block' : 'hidden' }}">
            <h1 class="text-orange-500">Pouvant être acheté sur</h1>
            <hr class="border-orange-500"/>
            
            <div class="flex gap-4">
                <div class="w-1/2">
                    <label class="block text-gray-600 text-sm font-semibold mb-2" for="website_id">Site de vente <span class="required">*</span></label>
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
                        <label class="block text-gray-600 text-sm font-semibold mb-2" for="price">Prix du site (€) <span class="required">*</span></label>
                        <input class="bg-gray-100 appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="price" id="price" type="text" placeholder="50" value="{{ old('price') }}"/>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-1/2">
                        <label class="block text-gray-600 text-sm font-semibold mb-2" for="expiration_date">Date d'expiration</label>
                        <input class="bg-gray-100 appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="expiration_date" id="expiration_date" type="date" value="{{ old('expiration_date') }}"/>
                        @error('expiration_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="my-4">
                <label class="block text-gray-600 text-sm font-semibold mb-2" for="url">Url</label>
                <input class="bg-gray-100 appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="url" id="url" type="text" placeholder="http://Amazon.fr" value="{{ old('url') }}"/>
                @error('url')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        
        <!-- Formulaire d'achat -->
        
        <div id="section_purchase" class="{{ strcmp(old('add_purchase'), 'on') === 0 ? 'block' : 'hidden' }}">
            <h1 class="text-red-500">Données sur l'achat effectué</h1>
            <hr class="border-red-500"/>
            
            <div class="flex gap-4 mb-4">
                <div class="w-1/2">
                    <label class="block text-gray-600 text-sm font-semibold mb-2" for="product_state_id">Etat du produit <span class="required">*</span></label>
                    <select name="product_state_id" id="product_state_id" class="pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                        @foreach($product_states as $product_state)
                            <option value="{{ $product_state->id }}" @if(old('product_state_id') === $product_state->id) selected @endif>{{ $product_state->label }}</option>
                        @endforeach
                    </select>
                    @error('product_state_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="flex justify-around gap-4 w-1/2">
                    <div class="w-1/2">
                        <label class="block text-gray-600 text-sm font-semibold mb-2" for="cost">Coût (€) <span class="required">*</span></label>
                        <input class="bg-gray-100 appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="cost" id="cost" type="text" placeholder="Ce produit m'a coûté..." value="{{ old('cost') }}"/>
                        @error('cost')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-1/2">
                        <label class="block text-gray-600 text-sm font-semibold mb-2" for="date">Date d'achat <span class="required">*</span></label>
                        <input class="bg-gray-100 appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="date" id="date" type="date" value="{{ old('date') }}"/>
                        @error('date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>


        <div class="mb-4">
            <input onChange="set_purchase(this.checked);" class="mr-1" type="checkbox" name="add_purchase" id="add_purchase" {{ strcmp(old('add_purchase'), 'on') === 0 ? 'checked' : '' }}/>
            <label class="text-gray-600 text-sm font-semibold mb-2" for="add_purchase">Créer & lier un achat</label>
        </div>
        <div class="flex items-center justify-between">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                Ajouter le produit
            </button>
            <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="{{ route('products.index') }}">Annuler</a>
        </div>
    </form>
    </div>
@endsection