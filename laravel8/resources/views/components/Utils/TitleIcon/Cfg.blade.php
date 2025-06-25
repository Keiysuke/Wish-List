<a 
    title="{{ $cfg->project_name }}" 
    href="{{ htmlspecialchars($cfg->project_url) }}" target="_blank"  
    class="title-icon idea inline-flex {{ $class ?? '' }}"
    >
    <x-svg.big.idea class="icon-xs"/>
</a>