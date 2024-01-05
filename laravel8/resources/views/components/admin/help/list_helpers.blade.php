<div class="help_block">
    <x-svg.big.help class="icon_help icon-lg"/>
    <div class="components_list">
        @if(isset($elements))
            @foreach ($elements as $element)
                <span>{{ $element }}</span>
            @endforeach
        @else
            {{ $slot }}
        @endif
    </div>
</div>