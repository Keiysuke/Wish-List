<div id="content_filters" class="flex flex-col gap-4 mb-8 hidden">
    <div class="flex flex-grow justify-center gap-4">
        <div class="filter_block flex flex-col items-center gap-2">
            <p class="w-full text-center px-4 border-b-only border-gray-300 bg-gray-200 font-semibold p-1">Sites de vente</p>
            <div class="grid grid-cols-2 gap-x-12 px-8">
                @foreach ($websites as $website)
                    <div class="inline-flex">
                        <input class="mr-2 mt-1 filter_website" type="checkbox" name="website_{{ $website->id }}" id="website_{{ $website->id }}" checked/>
                        <label class="text-gray-600 text-sm font-semibold mb-2" for="website_{{ $website->id }}">{{ $website->label }}</label>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="filter_block flex flex-col items-center gap-2">
            <p class="w-full text-center px-4 border-b-only border-gray-300 bg-gray-200 font-semibold p-1">Produits achetés</p>
            <div class="grid grid-cols-2 gap-2 gap-x-12 px-8">
                <div class="inline-flex">
                    <input class="mr-2 mt-1" type="radio" name="purchased" id="purchased_all" value="purchased_all" checked/>
                    <label class="text-gray-600 text-sm font-semibold mb-2" for="purchased_all">Tous</label>
                </div>
                <div class="inline-flex">
                    <input class="mr-2 mt-1" type="radio" name="purchased" id="purchased_yes" value="purchased_yes"/>
                    <label class="text-gray-600 text-sm font-semibold mb-2" for="purchased_yes">Achetés</label>
                </div>
                <div class="inline-flex">
                    <input class="mr-2 mt-1" type="radio" name="purchased" id="purchased_no" value="purchased_no"/>
                    <label class="text-gray-600 text-sm font-semibold mb-2" for="purchased_no">Pas achetés</label>
                </div>
                <div class="inline-flex">
                    <input class="mr-2 mt-1" type="radio" name="purchased" id="selling" value="selling"/>
                    <label class="text-gray-600 text-sm font-semibold mb-2" for="selling">En vente</label>
                </div>
                <div class="inline-flex">
                    <input class="mr-2 mt-1" type="radio" name="purchased" id="resold" value="resold"/>
                    <label class="text-gray-600 text-sm font-semibold mb-2" for="resold">Re/vendus</label>
                </div>
            </div>
        </div>
        <div class="filter_block flex flex-col items-center gap-2">
            <p class="w-full text-center px-4 border-b-only border-gray-300 bg-gray-200 font-semibold p-1">Stock des produits</p>
            <div class="grid grid-cols-2 gap-2 gap-x-12 px-8">
                <div class="inline-flex">
                    <input class="mr-2 mt-1" type="radio" name="stock" id="product_all" value="product_all" checked/>
                    <label class="text-gray-600 text-sm font-semibold mb-2" for="product_all">Tous</label>
                </div>
                <div class="inline-flex">
                    <input class="mr-2 mt-1" type="radio" name="stock" id="product_available" value="product_available" {{ ($filters->stock === 'product_available')? 'checked' : '' }}/>
                    <label class="text-gray-600 text-sm font-semibold mb-2" for="product_available">Disponibles</label>
                </div>
                <div class="inline-flex">
                    <input class="mr-2 mt-1" type="radio" name="stock" id="product_to_come" value="product_to_come" {{ ($filters->stock === 'product_to_come')? 'checked' : '' }}/>
                    <label class="text-gray-600 text-sm font-semibold mb-2" for="product_to_come">A venir</label>
                </div>
                <div class="inline-flex">
                    <input class="mr-2 mt-1" type="radio" name="stock" id="product_expired" value="product_expired" {{ ($filters->stock === 'product_expired')? 'checked' : '' }}/>
                    <label class="text-gray-600 text-sm font-semibold mb-2" for="product_expired">Expirés</label>
                </div>
                <div class="inline-flex">
                    <input class="mr-2 mt-1" type="radio" name="stock" id="product_missing" value="product_missing" {{ ($filters->stock === 'product_missing')? 'checked' : '' }}/>
                    <label class="text-gray-600 text-sm font-semibold mb-2" for="product_missing">Manquantes</label>
                </div>
            </div>
        </div>
        <div class="filter_block flex flex-col items-center gap-2">
            <p class="w-full text-center px-4 border-b-only border-gray-300 bg-gray-200 font-semibold p-1">Nombre de Résultats</p>
            <div class="grid grid-cols-2 gap-2 gap-x-12 px-8">
                <div class="inline-flex">
                    <input class="mr-2 mt-1" type="radio" name="f_nb_results" id="few_results" value="15" checked/>
                    <label class="text-gray-600 text-sm font-semibold mb-2" for="few_results">15 Résultats</label>
                </div>
                <div class="inline-flex">
                    <input class="mr-2 mt-1" type="radio" name="f_nb_results" id="mid_results" value="30" {{ ($filters->f_nb_results == 30)? 'checked' : '' }}/>
                    <label class="text-gray-600 text-sm font-semibold mb-2" for="mid_results">30 Résultats</label>
                </div>
                <div class="inline-flex">
                    <input class="mr-2 mt-1" type="radio" name="f_nb_results" id="big_results" value="50" {{ ($filters->f_nb_results == 50)? 'checked' : '' }}/>
                    <label class="text-gray-600 text-sm font-semibold mb-2" for="big_results">50 Résultats</label>
                </div>
            </div>
        </div>
    </div>
    <div class="flex justify-center">
        <button type="submit" class="w-1/6 p-2 col-5 rounded text-white bg-blue-500 hover:bg-blue-400">Appliquer les filtres</button>
    </div>
</div>