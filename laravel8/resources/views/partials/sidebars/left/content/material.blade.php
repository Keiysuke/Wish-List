@foreach ($materials as $material)
    <div class="material_{{ $material->id }} flex flex-col gap-1 mb-4">
        <x-sidebars.datas.material :material="$material" />
    </div>
@endforeach