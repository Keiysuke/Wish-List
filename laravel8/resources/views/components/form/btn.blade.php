@php($color = empty($color) ? 'blue' : $color)
@switch($color)
    @case('white')
        @php($customColor = 'border-black border-2')
        @break
    @case('black')
        @php($customColor = 'bg-black text-white')
        @break
    @default
        @php($customColor = 'bg-'.$color.'-500 hover:bg-'.$color.'-700 text-white')
        @break
@endswitch
<button 
    class="{{ $customColor }} font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline {{ $class ?? '' }}" 
    {{ $attributes }} 
    >
    {{ $slot }}
</button>