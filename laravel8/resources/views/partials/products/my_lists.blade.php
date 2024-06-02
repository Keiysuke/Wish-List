<div id="add-to-list" class="absolute flex justify-center items-center w-full h-full hidden">
    <div class="flex flex-col fixed z-30 w-60 h-96 border bg-gray-200 border-gray-800 divide-y divide-black">
        <div class="flex justify-between gap-2 pl-2 pr-1 py-1">
            <h3>{{ __("Save in") }}...</h3>
            <x-svg.close class="icon-lg icon-clickable hover:text-blue-500" onClick="toggleShowLists();"/>
        </div>
        <div class="h-full flex flex-col gap-2 p-3 pl-6 my-scrollbar scrollbar-thumb-rounded scrollbar-thumb-gray-700 scrollbar-track-gray-400">
            @if(count($lists) === 0)
                Vous n'avez aucune liste...
            @else
                @foreach ($lists as $list)
                <div class="flex inline-flex gap-2">
                    x <input type="text" name="nb_{{ $list->id }}" id="list-nb-{{ $list->id }}" class="px-1 h-6 w-12" value="{{ isset($list->product_nb)? $list->product_nb : 1 }}" onkeyup="toggleList({{ $list->id }}, {{ $product_id }}, false);"/>
                    <input type="checkbox" name="{{ $list->id }}" id="list-{{ $list->id }}" class="cursor-pointer mt-1" onChange="toggleList({{ $list->id }}, {{ $product_id }});" {{ $list->hasProduct ? 'checked' : '' }}/>
                    <label class="ml-1 hover:text-blue-500 cursor-pointer" for="list-{{ $list->id }}">{{ $list->label }}</label>
                </div>
                @endforeach
            @endif
        </div>
        <a href="{{ route("lists.create") }}" class="inline-flex p-1 hover:text-blue-500"><x-svg.plus class="icon-sm"/> Créer une liste</a>
    </div>
</div>