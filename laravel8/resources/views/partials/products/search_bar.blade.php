<div id="search_bar" class="inline-flex border-2 rounded shadow">
    <div class="relative mx-auto text-gray-600 lg:block hidden w-full">
        <input type="text" class=" p-2 w-80 pr-8" placeholder="{{ __('Search products...') }}" id="search_text" name="search_text" onKeyUp="search_products();" value="{{ $search }}">
        <button type="submit" class="absolute right-0 top-0 mt-3 mr-2">
            <x-svg.search class="icon-xs text-gray-400 pt-1 pr-1"/>
        </button>
    </div>

    <div class="flex justify-center items-center border-l-2 w-full px-2 gap-1">
        <label class="text-xs text-gray-600 font-semibold" for="sort_by">{{ __('Sort by') }}</label>
        <select class="text-sm border border-gray-300 rounded p-1 pr-5 bg-right" name="sort_by" id="sort_by" onChange="search_products();">
            <option value="date" {{ $sortBy->kind === 'date' ? 'selected' : '' }}>{{ __('Created date') }}</option>
            <option value="alpha" {{ $sortBy->kind === 'alpha' ? 'selected' : '' }}>{{ __('Alphabetic') }}</option>
            <option value="price" {{ $sortBy->kind === 'price' ? 'selected' : '' }}>{{ __('Price') }}</option>
        </select>
    </div>
    <div class="flex justify-center items-center border-l-2" id="title_order_by" title="{{ $sortBy->order === 'asc' ? __('Ascending order') : __('Descending order') }}">
        <input type="hidden" name="order_by" id="order_by" value="{{ $sortBy->order }}"/>
        <x-svg.asc id="icon_asc_sort" onClick="sort('desc');" class="icon-sm icon-clickable mx-3 pt-1 {{ $sortBy->order === 'asc' ? '' : 'hidden' }}"/>
        <x-svg.desc id="icon_desc_sort" onClick="sort('asc');" class="icon-sm icon-clickable mx-3 pt-1 {{ $sortBy->order === 'desc' ? '' : 'hidden' }}"/>
    </div>
    
    <div class="flex justify-center items-center border-l-2" title="{{ __('Edit filters') }}">
        <x-svg.filter onClick="toggle_filters();" class="icon-xs icon-clickable mx-3" id="icon_filter"/>
    </div>
    
    <div class="flex justify-center items-center border-l-2" id="title_show_archived" title="{{ !$sortBy->show_archived ? __('Show archived') : __('Hide archived') }}">
        <input type="hidden" name="show_archived" id="show_archived" value="{{ $sortBy->show_archived }}"/>
        <x-svg.archive id="icon_show_archived" onClick="toggle_archived();" class="icon-sm mx-3 pt-1"/>
    </div>
    
    <div id="icon_list" class="flex justify-center items-center border-l-2" title="{{ __('Grid') }}">
        <input type="hidden" name="list" id="list" value="{{ $sortBy->list }}"/>
        <x-svg.grid title="{{ __('Grid') }}" id="result_icon_grid" onClick="display_result('grid');" class="icon-xs icon-clickable mx-3 hidden"/>
        <x-svg.list title="{{ __('List') }}" id="result_icon_list" onClick="display_result('list');" class="icon-xs icon-clickable mx-3"/>
    </div>
</div>