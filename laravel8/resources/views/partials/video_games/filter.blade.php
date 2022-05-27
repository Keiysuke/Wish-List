<div id="content_filters" class="flex flex-col gap-4 mb-8 hidden">
    <div class="flex flex-grow justify-center gap-4">
        <div class="filter_block flex flex-col w-1/2 items-center gap-2">
            <div class="relative w-full text-center px-4 border-b-only border-gray-300 bg-gray-200 font-semibold p-1">
                <div class="flex inline-flex gap-2 absolute top-2 left-2 text-xs">
                    <label for="no_vg_support">Aucun <input class="ml-1" id="no_vg_support" name="no_vg_support" type="checkbox"/></label>
                </div>
                Support de JV
                <label class="absolute top-2 right-2 text-xs">Dé/cocher tout <input class="ml-1" id="check_all_vg_supports" type="checkbox"/></label>
            </div>
            <div class="grid grid-cols-6 gap-x-12 px-8">
                @foreach ($vg_supports as $vg_support)
                    <div class="inline-flex">
                        <x-form.checkbox class="mr-2 mt-1 filter_vg_support" name="vg_support_{{ $vg_support->id }}">checked</x-form.checkbox>
                        <x-form.label for="vg_support_{{ $vg_support->id }}">{{ $vg_support->alias }}</x-form.label>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="filter_block flex flex-col items-center gap-2">
            <p class="w-full text-center px-4 border-b-only border-gray-300 bg-gray-200 font-semibold p-1">Jeux Vidéo achetés</p>
            <div class="grid grid-cols-2 gap-2 gap-x-12 px-8">
                <x-filter.radio name="purchased" value="purchased_all" checked>Tous</x-filter.radio>
                <x-filter.radio name="purchased" value="purchased_yes">Achetés</x-filter.radio>
                <x-filter.radio name="purchased" value="purchased_no">Pas achetés</x-filter.radio>
                <x-filter.radio name="purchased" value="resold">Re/vendus</x-filter.radio>
            </div>
        </div>
        <div class="filter_block flex flex-col items-center gap-2">
            <p class="w-full text-center px-4 border-b-only border-gray-300 bg-gray-200 font-semibold p-1">Nombre de Résultats</p>
            <div class="grid grid-cols-2 gap-2 gap-x-12 px-8">
                <x-filter.radio name="f_nb_results" id="few_results" value="24" checked>24 Résultats</x-filter.radio>
                <x-filter.radio name="f_nb_results" id="mid_results" value="48">48 Résultats</x-filter.radio>
                <x-filter.radio name="f_nb_results" id="big_results" value="80">80 Résultats</x-filter.radio>
            </div>
        </div>
    </div>
    <div class="flex justify-center">
        <button type="submit" class="w-1/6 p-2 col-5 rounded text-white bg-blue-500 hover:bg-blue-400">Appliquer les filtres</button>
    </div>
</div>