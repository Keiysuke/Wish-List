@switch($type)
    @case('buy')
        @if($nb > 0)
            <div class="inline-flex text-orange-500 mr-2" title="Achats effectués"><x-svg.cart class="icon-xs"/>x {{ $nb }}</div>
        @endif
        @break
    @case('sell')
        @if($nb > 0)
            <div class="inline-flex text-green-500 mr-2" title="Ventes en cours"><x-svg.truck class="icon-xs"/>x {{ $nb }}</div>
        @endif
        @break
    @case('resell')
        @if($nb > 0)
            <div class="inline-flex text-blue-500" title="Ventes terminées"><x-svg.euro class="icon-xs"/>x {{ $nb }}</div>
        @endif
        @break
@endswitch