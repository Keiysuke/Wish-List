
@php($expire = strcmp($notif->type, 'App\Notifications\ProductSoonExpire'))
<x-Notif 
    :notif="$notif" 
    icon="svg.clock" 
    kind="warning" 
    title="{{ $expire ? __('Soon available') : __('Soon expired') }}"
    >
    <a href="{{ route('products.showFromNotification', ['product' => $notif->data['product_id'], 'notification' => $notif->id]) }}" 
        class="flex items-center mx-1 bg-white" 
        title="{{ $notif->data['product_label'] }}"
        >
        <img class="w-2/6 h-20" src="{{ asset(config('images.path_products').'/'.$notif->data['product_id'].'/'.$notif->data['product_photo']) }}"/>
        <span class="w-4/6 flex justify-center text-black text-sm">
            {{ $expire ? __('Disponible') : __('Expire') }} dans {{ $notif->data['days'] }} jour(s)
        </span>
    </a>
</x-Notif>