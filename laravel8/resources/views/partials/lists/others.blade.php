@foreach ($listing_users as $friend_id => $lists)
<div id="list_type_{{ $friend_id }}" class="list_type">
    <div class="label">{{ $users_name[$friend_id] }}</div>
    <div id="content_list_type_{{ $friend_id }}" class="all_lists">
    @foreach ($lists as $list)
        <div id="list_{{ $list->id }}" class="flex w-full gap-2 cursor-pointer text-sm">
            <div class="flex w-full justify-between hover:text-red-500 hover:underline" onClick="get_products({{ $list->id }});">
                <span class="inline-flex">{{ $list->label }}
                    @if($list->secret)
                        <x-svg.big.gift class="icon-xs ml-1 text-red-400"/>
                    @endif
                </span>
            </div>
            <x-svg.log_out title="Quitter la liste ?" class="icon-xs icon-clickable hover:text-red-600" onClick="if(confirm('Confirmez-votre choix')) { leave_list('{{ $list->id }}'); }"/>
        </div>
    @endforeach
        </div>
    </div>
@endforeach