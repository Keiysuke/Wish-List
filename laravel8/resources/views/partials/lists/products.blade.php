<div id="title-list" class="w-full flex inline-flex gap-1 border-b mb-2 py-2 relative">
    <span class="inline-flex text-xl font-bold">{{ $list->label }}
        @if($list->secret)
            <x-svg.big.gift class="icon-sm ml-1"/>
        @endif
    </span>
    @if($list->owned())
        <span class="font-light" style="margin-top:0.10rem;"> - {{ $list->isShared() ? 'Partagée' : 'Privée' }}</span>
    @endif
    <div class="absolute right-0">
        @php($color = 'text-'.$products->color_price.'-600')
        <span id="total-price" title="Montant réel : {{ $products->total_price }} €">Montant total : <span class="{{ $color }}">{{ $products->total_best_price }} €</span></span>
        @if($list->owned())
            <span class="title-icon cursor-pointer inline-flex ml-1" onClick="showShareList({{ $list->id }});">
                <x-svg.share title="Partager la liste ?" class="icon-xs"/>
            </span>
        @endif
        <span class="title-icon excel cursor-pointer inline-flex ml-1" onClick="if(confirm('Télécharger la liste ?')){ downloadList({{ $list->id }}); }">
            <x-svg.excel title="Télécharger la liste ?" class="icon-xs"/>
        </span>
    </div>
</div>
@if(!empty($list->description))
    <div class="text-sm italic mb-2">{{ $list->description }}</div>
@endif
<h2 class="mb-2" id="nb-results" data-nb="{{ $nb_results }}">{{ $nb_results }} produit(s)</h2>

@include('lists.products.details', compact($products, $list))