<td>
@if(isset($label))
    @if(!isset($color) && isset($benef))
        @if ($label > 100)
            @php($color = 'purple-500')
        @elseif ($label > 50)
            @php($color = 'blue-500')
        @elseif ($label > 0)
            @php($color = 'green-500')
        @else
            @php($color = 'red-500')
        @endif
    @endif
    <p class="text-{{ $color ?? 'gray-700' }} mr-2 {{ $class ?? '' }}">{{ $label }}</p>
@else
    {{ $slot }}
@endif
</td>