<div id="content_filters" class="flex flex-col gap-4 mb-8 hidden">
    <div class="flex flex-grow justify-center gap-4">
        <div class="filter_block flex flex-col w-1/2 items-center gap-2">
            <div class="relative w-full text-center px-4 border-b-only border-gray-300 bg-gray-200 font-semibold p-1">
                <div class="flex inline-flex gap-2 absolute top-2 left-2 text-xs">
                    <label for="no_tag">Aucun <input class="ml-1" id="no_tag" name="no_tag" type="checkbox"/></label>
                    <label for="exclusive_tags">Exclusif <input class="ml-1" id="exclusive_tags" name="exclusive_tags" type="checkbox"/></label>
                </div>
                Tags
                <label class="absolute top-2 right-2 text-xs">Dé/cocher tout <input class="ml-1" id="check_all_tags" type="checkbox" checked/></label>
            </div>
            <div class="grid grid-cols-{{ (count($tags) >= 12)? 4 : 3 }} gap-x-12 gap-y-2 px-8">
                @foreach ($tags as $tag)
                    <div class="inline-flex">
                        <x-form.checkbox class="mr-2 mt-1 filter_tag" name="tag_{{ $tag->id }}"></x-form.checkbox>
                        <x-form.label for="tag_{{ $tag->id }}"><x-tags.tag :tag="$tag"/></x-form.label>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="filter_block flex flex-col w-1/2 items-center gap-2">
            <p class="relative w-full text-center px-4 border-b-only border-gray-300 bg-gray-200 font-semibold p-1">Sites de vente <label class="absolute top-2 right-2 text-xs">Dé/cocher tout <input class="ml-1" id="check_all_websites" type="checkbox"/></label></p>
            <div class="grid grid-cols-5 gap-x-12 px-8">
                @foreach ($websites as $website)
                    <div class="inline-flex">
                        <x-form.checkbox class="mr-2 mt-1 filter_website" name="website_{{ $website->id }}">checked</x-form.checkbox>
                        <x-form.label for="website_{{ $website->id }}">{{ $website->label }}</x-form.label>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="flex flex-grow justify-center gap-4">
        <div class="filter_block flex flex-col items-center gap-2">
            <p class="w-full text-center px-4 border-b-only border-gray-300 bg-gray-200 font-semibold p-1">Produits achetés</p>
            <div class="grid grid-cols-4 gap-2 gap-x-12 px-8">
                <x-filter.radio name="purchased" value="purchased_all" checked>Tous</x-filter.radio>
                <x-filter.radio name="purchased" value="purchased_yes">Achetés</x-filter.radio>
                <x-filter.radio name="purchased" value="purchased_no">Pas achetés</x-filter.radio>
                <x-filter.radio name="purchased" value="not_received">Pas reçu</x-filter.radio>
                <x-filter.radio name="purchased" value="selling">En vente</x-filter.radio>
                <x-filter.radio name="purchased" value="resold">Re/vendus</x-filter.radio>
                <x-filter.radio name="purchased" value="discount">En réduction</x-filter.radio>
                <x-filter.radio name="purchased" value="free">Gratuits</x-filter.radio>
            </div>
        </div>
        <div class="filter_block flex flex-col items-center gap-2">
            <p class="w-full text-center px-4 border-b-only border-gray-300 bg-gray-200 font-semibold p-1">Stock des produits</p>
            <div class="grid grid-cols-3 gap-2 gap-x-12 px-8">
                <x-filter.radio name="stock" value="product_all" checked>Tous</x-filter.radio>
                <x-filter.radio name="stock" value="product_available">Disponibles</x-filter.radio>
                <x-filter.radio name="stock" value="product_to_come">A venir</x-filter.radio>
                <x-filter.radio name="stock" value="product_expired">Expirés</x-filter.radio>
                <x-filter.radio name="stock" value="product_missing">Manquantes</x-filter.radio>
            </div>
        </div>
        <div class="filter_block flex flex-col items-center gap-2">
            <p class="w-full text-center px-4 border-b-only border-gray-300 bg-gray-200 font-semibold p-1">Nombre de Résultats</p>
            <div class="grid grid-cols-2 gap-2 gap-x-12 px-8">
                <x-filter.radio name="f_nb_results" id="few_results" value="15" checked>15 Résultats</x-filter.radio>
                <x-filter.radio name="f_nb_results" id="mid_results" value="30">30 Résultats</x-filter.radio>
                <x-filter.radio name="f_nb_results" id="big_results" value="50">50 Résultats</x-filter.radio>
            </div>
        </div>
    </div>
    <div class="flex justify-center">
        <button type="submit" class="w-1/6 p-2 col-5 rounded text-white bg-blue-500 hover:bg-blue-400">Appliquer les filtres</button>
    </div>
</div>