@php($expire = strcmp($notif->type, 'App\Notifications\MissingProductOnVideoGame'))
<x-Notif 
    :notif="$notif" 
    icon="svg.warning" 
    kind="warning" 
    title="{{ __('Missing product') }}"
    >
    <a href="{{ route('video_games.show', ['video_game' => $notif->data['video_game_id'], 'notification' => $notif->id]) }}" 
        class="bg-white" 
        title="Editer le produit du jeu vidéo"
        >
        <span class="text-black text-sm">
            Jeu vidéo concerné :
        </span>
        <span class="italic flex justify-center text-black text-xs">{{ $notif->data['video_game_label'] }}</span>
    </a>
</x-Notif>