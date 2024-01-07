<div id="title_list" class="w-full flex inline-flex gap-1 border-b mb-2 py-2 relative">
    <span class="inline-flex text-xl font-bold">{{ $list->label }}
        @if($list->secret)
            <x-svg.big.gift class="icon-sm ml-1"/>
        @endif
    </span>
    @if($list->owned())
        <span class="font-light" style="margin-top:0.10rem;"> - {{ $list->isShared() ? 'Partagée' : 'Privée' }}</span>
    @endif
    <div class="absolute right-0">
        <span id="total_price">Montant total : {{ $products->total_price }} €</span>
        @if($list->owned())
            <span class="title-icon cursor-pointer inline-flex ml-1" onClick="showShareList({{ $list->id }});">
                <x-svg.share title="Partager la liste ?" class="icon-xs"/>
            </span>
        @endif
        <span class="title-icon excel cursor-pointer inline-flex ml-1" onClick="if(confirm('Télécharger la liste ?')){ download_list({{ $list->id }}); }">
            <x-svg.excel title="Télécharger la liste ?" class="icon-xs"/>
        </span>
    </div>
</div>
<h2 class="mb-2" id="nb_results" data-nb="{{ count($products) }}">{{ count($products) }} Résultat(s)</h2>

@include('lists.products.details', $products)