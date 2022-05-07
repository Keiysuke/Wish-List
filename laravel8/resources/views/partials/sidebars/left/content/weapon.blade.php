@foreach ($weapons as $weapon)
    <div class="weapon_{{ $weapon->id }} flex flex-col items-center gap-1 my-8">
        <div class="flex inline-flex gap-2">
            <x-sidebars.datas.weapon :weapon="$weapon"/>
        </div>
        <x-sidebars.datas.weapon_parts :weapon="$weapon"/>
    </div>
@endforeach