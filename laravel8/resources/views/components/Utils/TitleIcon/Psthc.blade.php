@if($support && $support->isPsn())
<a 
    {{ $attributes }} 
    title="{{ $title ?? "Voir les succès" }}" 
    href="{{ MySearch::getLink('psthc', $search) }}" 
    target="_blank" 
    class="title-icon trophy inline-flex {{ $class ?? '' }}"
    >
    <x-svg.big.trophy class="icon-xs"/>
</a>
@endif