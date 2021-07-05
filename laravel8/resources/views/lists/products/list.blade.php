<div id="title_list" class="w-full flex inline-flex gap-1 border-b mb-2 py-2 relative">
    <span class="inline-flex text-xl font-bold">{{ $list->label }}
        @if($list->secret)
            <x-svg.big.gift class="icon-xs ml-1"/>
        @endif
    </span>
    <span class="font-light" style="margin-top:0.10rem;"> - {{ count($list->users) > 0 ? 'Partagée' : 'Privée' }}</span>
    <div class="absolute right-2">
        <span>Montant total : {{ $products->total_price }} €</span>
    </div>
</div>
<h2 id="nb_results" data-nb="{{ count($products) }}">{{ count($products) }} Résultat(s)</h2>

@include('lists.products.details', $products)