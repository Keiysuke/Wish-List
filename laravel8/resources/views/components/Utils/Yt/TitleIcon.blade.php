<a 
    {{ $attributes }} 
    title="{{ $title ?? "Ecouter l'OST" }}" 
    href="{{ MySearch::getLink('yt', $search) }}" 
    target="_blank" 
    class="title-icon music inline-flex {{ $class ?? '' }}"
    >
    <x-svg.music_note class="icon-xs"/>
</a>