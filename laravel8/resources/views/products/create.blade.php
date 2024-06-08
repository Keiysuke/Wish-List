@extends('template')

@section('breadcrumbs')
    {{ Breadcrumbs::render('create', 'product') }}
@endsection

@section('js')
<script type="text/javascript" src="{{ URL::asset('js/my_fetch.js') }}"></script>
<script>
    document.getElementById('ws-url').addEventListener('change', (e) => {
        const url = e.target.value;
        if (url === '') return;
        myFetch('{{ route('findByUrl') }}', {method: 'post', csrf: true}, {
            url: url,
        }).then(response => {
            if (response.ok) {
                return response.json();
            }
        }).then(res => {
            document.getElementById('website-id').value = res.id;
        });
    });
    
    function updatePrices(update = false) {
        if (update) {
            getConvertPrice('real-cost');
        }
        if (update || document.getElementById('price').value === '') document.getElementById('price').value = document.getElementById('real-cost').value;
        if (update || document.getElementById('cost').value === '') document.getElementById('cost').value = document.getElementById('real-cost').value;
    }

    function set_purchase(v) {
        document.getElementById('section-product-website').classList.toggle('hidden');
        document.getElementById('section-product-website').classList.toggle('block');
        document.getElementById('section-purchase').classList.toggle('hidden');
        document.getElementById('section-purchase').classList.toggle('block');
    }
    
    var loadFile = function(event) {
        URL.revokeObjectURL(event.target.files[0]);
        document.getElementById('img').src = URL.createObjectURL(event.target.files[0]);
    };
</script>
@endsection

@section('content')
<x-Notification type="success" msg="{{ session('info') }}"/>

<div class="min-w-full max-w-xs">
    <form class="bg-white rounded px-8 pt-6 pb-8 mb-4" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Formulaire du produit -->
        <h1>Ajout de produit</h1>
        <hr/>

        <input type="hidden" value="{{ Auth::user()->id }}" name="user_id" id="user-id"/>
        <div class="flex gap-4">
            <div class="flex flex-col items-center w-2/12">
                <input type="file" accept="image/*" id="photo-1" name="photo_1" class="hidden" onchange="loadFile(event)">
                <div class="inline-flex">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    <label class="custom-file-label cursor-pointer" for="photo-1" data-browse="Parcourir">Choisissez une image</label>
                </div>
                <label for="photo-1" class="cursor-pointer"><img id="img" class="border max-w-20 max-h-32" src="{{ asset('resources/images/no_pict.png') }}"/></label>
                @error('photo_1')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="flex flex-col w-7/12 gap-4">
                <div>
                    <x-Form.Label for="label" block required>Nom du produit</x-Form.Label>
                    <x-Form.Input name="label" placeholder="Uncharted 4" value="{{ old('label') }}"/>
                </div>
                <div class="flex gap-4">
                    <div class="w-1/5">
                        <x-Form.Label for="template-type" block>Type du produit</x-Form.Label>
                        <select name="template_type" id="template-type" class="pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                            <option value="none">Aucun</option>
                            <option value="video_game" @if(strcmp(old('template_type'), 'video_game') === 0) selected @endif>Jeu Vidéo</option>
                            <option value="vg_support" @if(strcmp(old('template_type'), 'vg_support') === 0) selected @endif>Support de JV</option>
                        </select>
                        @error('template_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-4/5">
                        <x-Form.Label for="product-type-linked" block>Associer avec l'existant</x-Form.Label>
                        <x-Form.Input name="product_type_linked" placeholder="Commencez à saisir le nom..." value="{{ old('product_type_linked') }}"/>
                    </div>
                </div>
            </div>

            <div class="flex justify-around w-3/12 gap-4">
                <div class="flex flex-col w-1/3 gap-4">
                    <div>
                        <x-Form.Label for="limited-edition" block>Edition limitée ?</x-Form.Label>
                        <x-Form.Input name="limited_edition" placeholder="3000" value="{{ old('limited_edition') }}"/>
                    </div>
                    <div>
                        <div class="relative flex inline-flex w-full">
                            <x-Form.Label for="real-cost" block required>Prix neuf (€)</x-Form.Label>
                            <x-Utils.Convert inputId="real-cost" onClick="updatePrices(true)"/>
                        </div>
                        <x-Form.Input id="real-cost" name="real_cost" placeholder="20.50" value="{{ old('real_cost') }}" onFocusOut="updatePrices()"/>
                    </div>
                </div>
                <div class="w-2/3">
                    <x-Form.Label for="tag-ids" block required create="{{ route('tags.create') }}">Tags associés</x-Form.Label>
                    <select multiple name="tag_ids[]" id="tag-ids" class="pl-2 h-32 block w-full rounded-md bg-gray-100 border-transparent">
                        @foreach($tags as $tag)
                            <option value="{{ $tag->id }}" @if(in_array($tag->id, old('tags_id', []))) selected @endif>{{ $tag->label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="my-4">
            <x-Form.Label for="description" block>Description</x-Form.Label>
            <x-Form.Textarea name="description">{{ old('description') }}</x-Form.Textarea>
        </div>
        
        <!-- Formulaire liaison de site de vente au produit -->

        <div id="section-product-website" class="{{ strcmp(old('add_purchase'), 'on') === 0 ? 'block' : 'hidden' }}">
            <h1 class="text-orange-500">Pouvant être acheté sur</h1>
            <hr class="border-orange-500"/>
            
            <div class="flex gap-4">
                <div class="w-1/2">
                    <x-Form.Label for="website-id" block required create="{{ route('websites.create') }}">Site de vente</x-Form.Label>
                    <select name="website_id" id="website-id" class="pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                        @foreach($websites as $website)
                            <option value="{{ $website->id }}" @if(old('website_id', auth()->user()->getFavWebsite()) == $website->id) selected @endif>{{ $website->label }}</option>
                        @endforeach
                    </select>
                    @error('website_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="flex justify-around gap-4 w-1/2">
                    <div class="w-1/2">
                        <x-Form.Label for="price" block required>Prix du site (€)</x-Form.Label>
                        <x-Form.Input name="price" placeholder="50" value="{{ old('price') }}"/>
                    </div>
                    <div class="w-1/2">
                        <x-Form.Label for="expiration-date" block>Date d'expiration</x-Form.Label>
                        <x-Form.Date name="expiration_date" value="{{ old('expiration_date') }}"/>
                    </div>
                </div>
            </div>
            <div class="my-4">
                <x-Form.Label for="url" block>Url</x-Form.Label>
                <x-Form.Input id="ws-url" name="url" placeholder="http://Amazon.fr" value="{{ old('url') }}"/>
            </div>
        </div>
        
        <!-- Formulaire d'achat -->
        
        <div id="section-purchase" class="{{ strcmp(old('add_purchase'), 'on') === 0 ? 'block' : 'hidden' }}">
            <h1 class="text-red-500">Données sur l'achat effectué</h1>
            <hr class="border-red-500"/>
            
            <div class="flex gap-4 mb-4">
                <div class="flex justify-around gap-4 w-1/2">
                    <div class="w-1/2">
                        <x-Form.Label for="product-state-id" block required create="{{ route('states.products.create') }}">Etat du produit</x-Form.Label>
                        <select name="product_state_id" id="product-state-id" class="pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                            @foreach($productStates as $productState)
                                <option value="{{ $productState->id }}" @if(old('product_state_id') == $productState->id) selected @endif>{{ $productState->label }}</option>
                            @endforeach
                        </select>
                        @error('product_state_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-1/2">
                        <div class="relative flex inline-flex w-full">
                            <x-Form.Label for="cost" block required>Coût (€)</x-Form.Label>
                            <x-Utils.Convert inputId="cost"/>
                        </div>
                        <x-Form.Input name="cost" type="text" placeholder="Ce produit m'a coûté..." value="{{ old('cost') }}"/>
                    </div>
                </div>
                <div class="flex justify-around gap-4 w-1/2">
                    <div class="w-1/4">
                        <x-Form.Label for="discount" block required>Réduction (€)</x-Form.Label>
                        <x-Form.Input name="discount" type="text" placeholder="0" value="{{ old('discount', 0) }}"/>
                    </div>
                    <div class="w-1/4">
                        <x-Form.Label for="customs" block required>Douane (€)</x-Form.Label>
                        <x-Form.Input name="customs" type="text" placeholder="0" value="{{ old('customs', 0) }}"/>
                    </div>
                    <div class="w-2/4">
                        <x-Form.Label for="date" block required>Date d'achat</x-Form.Label>
                        <x-Form.Date name="date" type="date" value="{{ old('date', $today) }}"/>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <x-Form.Checkbox onChange="set_purchase(this.checked);" name="add_purchase">{{ strcmp(old('add_purchase'), 'on') === 0 ? 'checked' : '' }}</x-Form.Checkbox>
            <x-Form.Label class="ml-1" for="add-purchase">Créer & lier un achat</x-Form.Label>
        </div>
        <div class="flex items-center justify-between">
            <x-Form.Btn type="submit">Ajouter le produit</x-Form.Btn>
            <x-Form.Cancel href="{{ route('products.index') }}"/>
        </div>
    </form>
    </div>
@endsection