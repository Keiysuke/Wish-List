<a {{ $attributes }} title="{{ $title ?? "Avis en ligne" }}" href="{{ MySearch::getLink('booknode', $search) }}" target="_blank" class="title-icon cursor-pointer inline-flex {{ $class ?? '' }}">
    <x-svg.like class="icon-xs"/>
</a>