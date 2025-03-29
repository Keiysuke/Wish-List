<a 
    title="{{ $title ?? 'Voir le produit associé' }}" 
    href="{{ route('products.show', $id) }}" 
    class="title-icon product inline-flex {{ $class ?? '' }}"
    >
    <x-svg.big.cart class="icon-xs"/>
</a>