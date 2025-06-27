@php($values = $values ?? (isset($all) ? [15, 30, 50, 100, 200] : [15, 30, 50, 100, 200, 300]))
<p class="w-full text-center px-4 border-b-only border-gray-300 bg-gray-200 font-semibold p-1">Nombre de Résultats</p>
<div class="grid grid-cols-3 gap-2 gap-x-12 px-8">
    @foreach ($values as $k => $value)
        @if (!$k)
            <x-filters.utils.radio name="f_nb_results" id="{{ $value }}-results" value="{{ $value }}" checked>{{ $value }} Résultats</x-filters.utils.radio>
        @else
            <x-filters.utils.radio name="f_nb_results" id="{{ $value }}-results" value="{{ $value }}">{{ $value }} Résultats</x-filters.utils.radio>
        @endif
    @endforeach
    @if(isset($all))
        <x-filters.utils.radio name="f_nb_results" id="all-results" value="all">Tous</x-filters.utils.radio>
    @endif
</div>