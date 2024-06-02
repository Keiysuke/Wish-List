<a 
    {{ $attributes }} 
    title="{{ $title ?? "Voir les succès" }}" 
    href="{{ \App\Http\Controllers\UtilsController::psthc($search, $support) }}/liste-trophees.htm" 
    target="_blank" 
    class="title-icon trophy inline-flex {{ $class ?? '' }}"
    >
    <x-svg.big.trophy class="icon-xs"/>
</a>