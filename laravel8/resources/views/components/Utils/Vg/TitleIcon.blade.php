<a 
    title="{{ $title ?? 'Voir le jeu vidéo' }}" 
    href="{{ route('video_games.show', $id) }}" 
    class="show-video-game title-icon inline-flex {{ $class ?? '' }}"
    >
    <x-svg.big.vg_controller class="icon-xs"/>
</a>