@foreach ($cosmetics as $cosmetic)
    <div class="cosmetic_{{ $cosmetic->id }} flex flex-col gap-1 mb-4">
        <x-sidebars.datas.cosmetic :cosmetic="$cosmetic"/>
    </div>
@endforeach