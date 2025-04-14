<div id="content-filters" class="flex flex-col gap-4 mb-8 hidden">
    <div class="flex flex-grow justify-center gap-4">
        <div class="filter_block flex flex-col w-1/2 items-center gap-2">
            <x-filters.vg.supports :vgSupports="$vgSupports"/>
        </div>
        <div class="filter_block flex flex-col items-center gap-2">
            <x-filters.vg.vg_bought/>
        </div>
        <div class="filter_block flex flex-col items-center gap-2">
            <x-filters.nb_results :values="[24, 48, 80]"/>
        </div>
    </div>
    <div class="flex justify-center">
        <button type="submit" class="w-1/6 p-2 col-5 rounded text-white bg-blue-500 hover:bg-blue-400">Appliquer les filtres</button>
    </div>
</div>