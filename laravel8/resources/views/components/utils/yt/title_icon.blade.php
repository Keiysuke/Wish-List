<a {{ $attributes }} title="{{ $title ?? "Ecouter l'OST" }}" href="https://www.youtube.com/results?search_query={{ str_replace(' ', '+', $search) }}" target="_blank" class="title-icon music inline-flex {{ $class ?? '' }}">
    <x-svg.big.music_note class="icon-xs"/>
</a>