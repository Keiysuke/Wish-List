<a {{ $attributes }} title="{{ $title ?? "Dénicher une offre" }}" href="{{ MySearch::getLink('offer', $search) }}" target="_blank" class="title-icon cursor-pointer inline-flex {{ $class ?? '' }}">
    <x-svg.search class="icon-xs"/>
</a>