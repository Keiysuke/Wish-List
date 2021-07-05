<div id="content_filters" class="flex flex-col gap-4 mb-8 hidden">
    <div class="flex flex-grow justify-center gap-4">
        <div class="filter_block flex flex-col items-center gap-2">
            <p class="relative w-full text-center px-4 border-b-only border-gray-300 bg-gray-200 font-semibold p-1">Sites de vente <label class="absolute top-2 right-2 text-xs">Dé/cocher tout <input id="check_all_websites" type="checkbox"/></label></p>
            <div class="grid grid-cols-{{ (count($websites) > 17)? '3' : '2' }} gap-x-12 px-8">
                @foreach ($websites as $website)
                    <div class="inline-flex">
                        <x-form.checkbox class="mr-2 mt-1 filter_website" name="website_{{ $website->id }}">checked</x-form.checkbox>
                        <x-form.label for="website_{{ $website->id }}">{{ $website->label }}</x-form.label>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="filter_block flex flex-col items-center gap-2">
            <p class="w-full text-center px-4 border-b-only border-gray-300 bg-gray-200 font-semibold p-1">Produits achetés</p>
            <div class="grid grid-cols-2 gap-2 gap-x-12 px-8">
                <div class="inline-flex">
                    <x-form.radio name="purchased" value="purchased_all">checked</x-form.radio>
                    <x-form.label class="text-gray-600 text-sm font-semibold mb-2" for="purchased_all">Tous</x-form.label>
                </div>
                <div class="inline-flex">
                    <x-form.radio name="purchased" value="purchased_yes"></x-form.radio>
                    <x-form.label for="purchased_yes">Achetés</x-form.label>
                </div>
                <div class="inline-flex">
                    <x-form.radio name="purchased" value="purchased_no"></x-form.radio>
                    <x-form.label for="purchased_no">Pas achetés</x-form.label>
                </div>
                <div class="inline-flex">
                    <x-form.radio name="purchased" value="selling"></x-form.radio>
                    <x-form.label for="selling">En vente</x-form.label>
                </div>
                <div class="inline-flex">
                    <x-form.radio name="purchased" value="resold"></x-form.radio>
                    <x-form.label for="resold">Re/vendus</x-form.label>
                </div>
            </div>
        </div>
        <div class="filter_block flex flex-col items-center gap-2">
            <p class="w-full text-center px-4 border-b-only border-gray-300 bg-gray-200 font-semibold p-1">Stock des produits</p>
            <div class="grid grid-cols-2 gap-2 gap-x-12 px-8">
                <div class="inline-flex">
                    <x-form.radio name="stock" value="product_all">checked</x-form.radio>
                    <x-form.label for="product_all">Tous</x-form.label>
                </div>
                <div class="inline-flex">
                    <x-form.radio name="stock" value="product_available">{{ ($filters->stock === 'product_available')? 'checked' : '' }}</x-form.radio>
                    <x-form.label for="product_available">Disponibles</x-form.label>
                </div>
                <div class="inline-flex">
                    <x-form.radio name="stock" value="product_to_come">{{ ($filters->stock === 'product_to_come')? 'checked' : '' }}</x-form.radio>
                    <x-form.label for="product_to_come">A venir</x-form.label>
                </div>
                <div class="inline-flex">
                    <x-form.radio name="stock" value="product_expired">{{ ($filters->stock === 'product_expired')? 'checked' : '' }}</x-form.radio>
                    <x-form.label for="product_expired">Expirés</x-form.label>
                </div>
                <div class="inline-flex">
                    <x-form.radio name="stock" value="product_missing">{{ ($filters->stock === 'product_missing')? 'checked' : '' }}</x-form.radio>
                    <x-form.label for="product_missing">Manquantes</x-form.label>
                </div>
            </div>
        </div>
        <div class="filter_block flex flex-col items-center gap-2">
            <p class="w-full text-center px-4 border-b-only border-gray-300 bg-gray-200 font-semibold p-1">Nombre de Résultats</p>
            <div class="grid grid-cols-2 gap-2 gap-x-12 px-8">
                <div class="inline-flex">
                    <x-form.radio name="f_nb_results" id="few_results" value="15">checked</x-form.radio>
                    <x-form.label for="few_results">15 Résultats</x-form.label>
                </div>
                <div class="inline-flex">
                    <x-form.radio name="f_nb_results" id="mid_results" value="30">{{ ($filters->f_nb_results == 30)? 'checked' : '' }}</x-form.radio>
                    <x-form.label for="mid_results">30 Résultats</x-form.label>
                </div>
                <div class="inline-flex">
                    <x-form.radio name="f_nb_results" id="big_results" value="50">{{ ($filters->f_nb_results == 50)? 'checked' : '' }}</x-form.radio>
                    <x-form.label for="big_results">50 Résultats</x-form.label>
                </div>
            </div>
        </div>
    </div>
    <div class="flex justify-center">
        <button type="submit" class="w-1/6 p-2 col-5 rounded text-white bg-blue-500 hover:bg-blue-400">Appliquer les filtres</button>
    </div>
</div>