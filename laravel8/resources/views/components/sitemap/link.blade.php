<a 
    href="{{ isset($url) ? $url : '#' }}" 
    class="sitemap-link ml-{{ isset($ml) ? $ml : '0' }}" 
    target="{{ isset($target) ? $target : '' }}"
    >
    <x-svg.upper class="icon-xs"/>
    <span>{{ __($label) }}</span>
</a>