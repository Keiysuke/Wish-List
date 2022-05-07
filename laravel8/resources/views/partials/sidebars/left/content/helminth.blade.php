@foreach ($helminths as $helminth)
    <div class="helminth_{{ $helminth->id }} flex flex-col gap-1 mb-4">
        <x-sidebars.datas.helminth :helminth="$helminth" />
    </div>
@endforeach