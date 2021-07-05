<a id="menu_{{ $id }}" onMouseOver="submenu(true, '{{ $id }}');" onMouseOut="submenu(false, '{{ $id }}');" href="{{ $href }}" class="navitem {{ !$active? 'not-' : '' }}active">
    {{ $slot }}
</a>