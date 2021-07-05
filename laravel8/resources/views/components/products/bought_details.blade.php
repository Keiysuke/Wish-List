<p class="text-gray-400">
    @if($product->nb_purchases > 0)
        <x-lists.icon_buy type="buy" nb="{{ $product->nb_purchases }}"/>
        <x-lists.icon_buy type="sell" nb="{{ $product->nb_sellings }}"/>
        <x-lists.icon_buy type="resell" nb="{{ $product->nb_resells }}"/>
    @else
        {{ $product->date_show }}
    @endif
</p>