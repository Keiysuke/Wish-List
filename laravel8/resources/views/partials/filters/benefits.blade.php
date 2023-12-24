<div id="content_filters" class="flex flex-col gap-4 mb-8 hidden">
    <div class="flex flex-grow justify-center gap-4">
        <div class="filter_block flex flex-col w-1/2 items-center gap-2">
            <x-filters.tags :tags="$tags" :filters="$filters"/>
        </div>
        <div class="filter_block flex flex-col w-1/2 items-center gap-2">
            <x-filters.websites :websites="$websites"/>
        </div>
    </div>
    <div class="flex flex-grow justify-center gap-4">
        <div class="filter_block flex flex-col items-center gap-2">
            <x-filters.products_bought kind="benefits"/>
        </div>
        <div class="filter_block flex flex-col items-center gap-2">
            <x-filters.period/>
        </div>
        <div class="filter_block flex flex-col items-center gap-2">
            <x-filters.nb_results all/>
        </div>
    </div>
    <div class="w-full flex gap-4 justify-center">
        <button type="submit" class="w-1/6 p-2 rounded text-white bg-blue-500 hover:bg-blue-400">Appliquer les filtres</button>
        <button type="button" id="reset_benefits_filters" class="p-2 rounded text-white bg-red-500 hover:bg-red-400">Réinitialiser</button>
    </div>
</div>