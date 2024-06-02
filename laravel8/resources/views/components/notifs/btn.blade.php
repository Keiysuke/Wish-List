@if(isset($important))
    @php($def_class = 'font-bold text-white bg-'.$color.'-500 rounded-md hover:bg-'.$color.'-700')
@else
    @php($def_class = 'font-semibold text-gray-800 bg-white border border-gray-400 rounded-md hover:bg-gray-100')
@endif
<button 
    class="px-4 py-2 focus:outline-none {{ $def_class }} {{ $class ?? '' }}" 
    {{ $attributes }}
    >
    {{ $slot ?? 'Refuser' }}
</button>