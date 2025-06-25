<x-Notif :notif="$notif" :kind="$notif->kind" :title="$notif->title">
    <a href="{{ route('products.showFromNotification', ['product' => $notif->data['product_id'], 'notification' => $notif->id]) }}" 
        class="flex items-center mx-1 bg-white" 
        title="{{ $notif->data['project_name'] }}"
        >
        <img class="w-2/6 h-20" src="{{ $notif->data['product_photo'] }}"/>
        <span class="w-4/6 flex text-center text-black text-sm">
            Date d'envoi non renseignée
        </span>
    </a>
</x-Notif>