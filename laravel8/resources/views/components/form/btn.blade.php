@php($color = isset($color) ? $color : 'blue')
<button class="bg-{{ $color }}-500 hover:bg-{{ $color }}-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline {{ $class ?? '' }}" {{ $attributes }} >
    {{ $slot }}
</button>