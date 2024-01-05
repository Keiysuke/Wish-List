<a {{ $attributes }} title="{{ $title ?? "Dénicher une offre" }}" href="https://ledenicheur.fr/search?search={{ str_replace(' ', '%20', $search) }}" target="_blank" class="title-icon cursor-pointer inline-flex {{ $class ?? '' }}">
    <x-svg.search class="icon-xs"/>
</a>