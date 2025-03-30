<a 
    title="{{ $title ?? 'Voir la maison d\'édition associée' }}" 
    href="{{ route('products.show', $id) }}" 
    class="title-icon book inline-flex {{ $class ?? '' }}"
    >
    <x-svg.big.book class="icon-xs"/>
</a>