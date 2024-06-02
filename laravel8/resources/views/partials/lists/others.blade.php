@foreach ($listingUsers as $friendId => $lists)
<div id="list-type-{{ $friendId }}" class="list-type">
    <div class="label">{{ $usersName[$friendId] }}</div>
    <div id="content-list-type-{{ $friendId }}" class="all-lists">
    @foreach ($lists as $list)
        <div id="list-{{ $list->id }}" class="flex w-full gap-2 cursor-pointer text-sm">
            <div class="flex w-full justify-between hover:text-red-500 hover:underline" onClick="getProducts({{ $list->id }});">
                <span class="inline-flex">{{ $list->label }}
                    @if($list->secret)
                        <x-svg.big.gift class="icon-xs ml-1 text-red-400"/>
                    @endif
                </span>
            </div>
            <x-svg.log_out 
                title="Quitter la liste ?" 
                class="icon-xs icon-clickable hover:text-red-600" 
                onClick="if(confirm('Confirmez-votre choix')) { leaveList('{{ $list->id }}'); }"
                />
        </div>
    @endforeach
        </div>
    </div>
@endforeach