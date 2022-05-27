<div class="ml-4 h-full">
    @if(count($products) == 0)
        Aucun produit associé
    @else
        <ul class="list-disc">
        @foreach ($products as $pvg)
            @php($best_offer = $pvg->product->bestWebsiteOffer())
            <li class="li_product" id="product_link_{{ $pvg->product->id }}">
                <div class="flex inline-flex gap-1">
                    {{ $pvg->product->label }} ({{ $pvg->vg_support->alias }}) pour <span class="font-semibold text-{{ $best_offer->color }}-500">{{ $best_offer->price }}€</span>
                    <x-svg.external_link class="icon-xs icon-clickable" href="{{ route('products.show', $pvg->product->id) }}" title="Voir le produit"/>
                    <span title="Dissocier le produit" class="unlink_product cursor-pointer inline-flex" onClick="return confirm('Dissocier le produit ?');">
                        <x-svg.trash class="icon-xs" data-id="{{ $pvg->product->id }}"/>
                    </span>
                </div>
            </li>
        @endforeach
        </ul>
    @endif
</div>