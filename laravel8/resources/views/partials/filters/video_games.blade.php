<div id="content-filters" class="flex flex-col gap-4 mb-8 hidden">
    <div class="flex flex-grow justify-center gap-4">
        <div class="filter_block flex flex-col w-1/2 items-center gap-2">
            <div class="relative w-full text-center px-4 border-b-only border-gray-300 bg-gray-200 font-semibold p-1">
                <div class="flex inline-flex gap-2 absolute top-2 left-2 text-xs">
                    <label for="no-vg-support">Aucun <input class="ml-1" id="no-vg-support" name="no_vg_support" type="checkbox"/></label>
                </div>
                Support de JV
                <label class="absolute top-2 right-2 text-xs">Dé/cocher tout <input class="ml-1" id="check-all-vg-supports" type="checkbox"/></label>
            </div>
            <div class="grid grid-cols-6 gap-x-12 px-8">
                @foreach ($vgSupports as $vgSupport)
                    <div class="inline-flex">
                        <x-Form.Checkbox class="mr-2 mt-1 filter-vg-support" name="vg_support_{{ $vgSupport->id }}">checked</x-Form.Checkbox>
                        <x-Form.Label for="vg-support-{{ $vgSupport->id }}">{{ $vgSupport->alias }}</x-Form.Label>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="filter_block flex flex-col items-center gap-2">
            <p class="w-full text-center px-4 border-b-only border-gray-300 bg-gray-200 font-semibold p-1">Jeux Vidéo achetés</p>
            <div class="grid grid-cols-2 gap-2 gap-x-12 px-8">
                <x-filters.utils.radio name="purchased" value="purchased_all" checked>Tous</x-filters.utils.radio>
                <x-filters.utils.radio name="purchased" value="purchased_yes">Achetés</x-filters.utils.radio>
                <x-filters.utils.radio name="purchased" value="purchased_no">Pas achetés</x-filters.utils.radio>
                <x-filters.utils.radio name="purchased" value="resold">Re/vendus</x-filters.utils.radio>
            </div>
        </div>
        <div class="filter_block flex flex-col items-center gap-2">
            <x-filters.nb_results :values="[24, 48, 80]"/>
        </div>
    </div>
    <div class="flex justify-center">
        <button type="submit" class="w-1/6 p-2 col-5 rounded text-white bg-blue-500 hover:bg-blue-400">Appliquer les filtres</button>
    </div>
</div>