@php($expire = strcmp($notif->type, 'App\Notifications\MissingPhotos'))
<x-Notif 
    :notif="$notif" 
    icon="svg.warning" 
    kind="warning" 
    title="{{ __('Missing pictures') }}"
    >
    <a href="{{ route('productPhotos.edit', ['product' => $notif->data['product_id'], 'notification' => $notif->id]) }}" 
        class="bg-white" 
        title="Editer les photos du produit"
        >
        <span class="text-black text-sm">
            Produit concerné :
        </span>
        <span class="italic flex justify-center text-black text-xs">{{ $notif->data['product_label'] }}</span>
    </a>
</x-Notif>