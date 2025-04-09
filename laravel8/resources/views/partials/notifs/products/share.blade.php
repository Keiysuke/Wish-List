<x-Notif :notif="$notif" icon="svg.share" kind="share" title="On vous a partagé un produit">
    <div class="flex justify-center">
        <a href="{{ route('products.index', ['id' => $notif->data['product_id']]) }}" class="link" title="{{ $notif->data['product_label'] }}">
            <img class="h-20" src="{{ $notif->data['product_photo'] }}"/>
        </a>
    </div>
    <div class="friend-request-row text-black" data-id="{{ $notif->data['user_id'] }}">
        <div class="avatar">
            {{ ($notif->data['user_name'])[0] }}
        </div>
        <div class="name">
            {{ $notif->data['user_name'] }}
        </div>
    </div>
</x-Notif>