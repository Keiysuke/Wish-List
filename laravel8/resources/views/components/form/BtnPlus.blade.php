@php($color = $color ?? 'blue')
@if(isset($href)) <a href="{{ $href }}">
@endif
<button {{ $attributes }} class="flex inline-flex mb-{{ $mb?? 4 }} text-sm bg-transparent hover:bg-{{ $color }}-300 text-{{ $color }}-700 font-semibold hover:text-white py-1 pr-1 border border-{{ $color }}-500 hover:border-transparent rounded">
    <x-svg.plus class="icon-sm"/>
    {{ $slot }}
</button>
@if(isset($href)) </a>
@endif