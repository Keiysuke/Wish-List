<a {{ $attributes }} title="{{ $title ?? "Rechercher des images" }}" href="{{ MySearch::getLink('pictures', $search) }}" target="_blank" class="title-icon cursor-pointer inline-flex {{ $class ?? '' }}">
    <x-svg.search class="icon-xs"/>
</a>