@foreach ($regions as $region)
    @php($checked_color = ($region->steel_path ? 'purple' : ($region->clear ? 'green' : 'white')))
    <div class="region_{{ $region->id }} flex flex-col gap-1 mb-8">
        <a href="{{ route('regions.edit', $region->id) }}" class="flex inline-flex text-{{ $checked_color }}-400">{{ $region->label }}</a>
        <div class="flex inline-flex justify-between">
            <span>{{ $region->mission->label }} - {{ $region->lvl }}</span>
            {{ $region->faction()->label }}
        </div>
        <span>
            @if(!is_null($region->photo))
            <img class="h-40" src="{{ asset(config('images.path_regions').'/'.$region->photo) }}"/>
            @endif
        </span>
    </div>
@endforeach