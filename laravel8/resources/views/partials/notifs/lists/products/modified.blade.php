<x-Notif :notif="$notif" :kind="$notif->kind" :title="$notif->title">
    <div class="flex flex-col content-center">
        <a href="{{ route('lists.index', ['id' => $notif->data['list_id']]) }}" class="link">
            <div class="flex justify-center gap-2 text-black">
                <x-svg.big.clipboard_list class="icon-sm"/><span class="font-semibold">{{ $notif->data['list_name'] }}</span>
            </div>
        </a>
        <a href="{{ route('products.show', ['product' => $notif->data['product_id']]) }}" title="Afficher le produit">
            <div class="flex gap-4 items-center">
                @if (isset($notif->edited))
                    <div class="flex flex-col gap-4">
                        <span class="italic flex justify-center text-black text-xs">{{ $notif->data['product_name'] }}</span>
                        <span class="flex justify-center text-black text-xs">
                            {{ __('Quantité : ').$notif->data['old_nb'].' => '.$notif->data['nb'] }}
                        </span>
                    </div>
                @else
                    <img class="w-2/6 h-20" src="{{ $notif->data['product_photo'] }}"/>
                    <span class="italic flex justify-center text-black text-xs">{{ $notif->data['product_name'] }}</span>
                @endif
            </div>
        </a>
    </div>
</x-Notif>