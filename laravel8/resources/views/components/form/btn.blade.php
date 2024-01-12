@php($color = isset($color) ? $color : 'blue')
@switch($color)
    @case('white')
    @php($custom_color = 'border-black border-2')
        @break
    @case('black')
        @php($custom_color = 'bg-black text-white')
        @break
    @default
        @php($custom_color = 'bg-'.$color.'-500 hover:bg-'.$color.'-700 text-white')
        @break
@endswitch
<button class="{{ $custom_color }} font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline {{ $class ?? '' }}" {{ $attributes }} >
    {{ $slot }}
</button>