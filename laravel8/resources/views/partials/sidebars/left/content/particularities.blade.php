<div class="flex flex-col gap-6 mb-4">
    @foreach ($particularities as $particularity)
        <div class="flex flex-col">
            <h3>{{ $particularity->label }}</h3>
            <span class="text-sm">{{ $particularity->description }}</span>
        </div>
    @endforeach
</div>