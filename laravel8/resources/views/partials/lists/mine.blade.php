@foreach ($listing_types as $listing_type_id => $lists)
<div id="list_type_{{ $listing_type_id }}" class="list_type">
    <div class="label">{{ $types_label[$listing_type_id] }}</div>
    <div id="content_list_type_{{ $listing_type_id }}" class="all_lists">
    @foreach ($lists as $list)
        <div id="list_{{ $list->id }}" class="flex w-full gap-2 cursor-pointer text-sm">
            <div class="flex w-full justify-between hover:text-red-500 hover:underline" onClick="get_products({{ $list->id }});">
                <span class="inline-flex">{{ $list->label }}
                    @if($list->secret)
                        <x-svg.big.gift class="icon-xs ml-1 text-red-400"/>
                    @endif
                </span>
                <span class="font-light">{{ $list->isShared() ? 'Partagée' : 'Privée' }}</span>
            </div>
            <a title="Editer la liste" href="{{ route('lists.edit', $list->id) }}">
                <x-svg.edit class="icon-xs icon-clickable"/>
            </a>
            <x-svg.trash title="Supprimer la liste ?" class="delete_list icon-xs icon-clickable hover:text-red-600" data-list_id="{{ $list->id }}"/>
        </div>
    @endforeach
        </div>
    </div>
@endforeach