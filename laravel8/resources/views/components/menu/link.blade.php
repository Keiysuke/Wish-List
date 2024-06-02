<a 
    class="navitem {{ !$active? 'not-' : '' }}active" 
    {{ $attributes }}
    >
    {{ $slot }}
</a>