<a id="menu_{{ $id }}" 
    onMouseOver="submenu(true, '{{ $id }}');" onMouseOut="submenu(false, '{{ $id }}');" 
    href="{{ $href ?? '' }}" 
    class="navitem {{ isset($active)? (!$active? 'not-' : '') : 'not-' }}active">
    {{ $slot }}
</a>