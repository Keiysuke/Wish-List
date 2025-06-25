@php($end = strcmp($notif->type, 'App\Notifications\CrowdfundingEndSoon'))
<x-Notif 
    :notif="$notif" 
    icon="svg.clock" 
    kind="warning" 
    title="{{ $end ? __('Soon available') : __('Soon expired') }}"
    >
    <a href="{{ route('products.showFromNotification', ['product' => $notif->data['product_id'], 'notification' => $notif->id]) }}" 
        class="flex items-center mx-1 bg-white" 
        title="{{ $notif->data['project_name'] }}"
        >
        <img class="w-2/6 h-20" src="{{ $notif->data['product_photo'] }}"/>
        <span class="w-4/6 flex text-center text-black text-sm">
            {{ $end ? __('Disponible') : __('Expire') }} dans {{ $notif->data['days'] }} jour(s)
        </span>
    </a>
</x-Notif>