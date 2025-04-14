<div class="relative w-full text-center px-4 border-b-only border-gray-300 bg-gray-200 font-semibold p-1">
    <div class="flex inline-flex gap-2 absolute top-2 left-2 text-xs">
        <label for="no-vg-support">Aucun <input class="ml-1" id="no-vg-support" name="no_vg_support" type="checkbox"/></label>
    </div>
    Support de JV
    <label class="absolute top-2 right-2 text-xs">Dé/cocher tout <input class="ml-1" id="check-all-vg-supports" type="checkbox"/></label>
</div>
<div class="grid grid-cols-6 gap-x-12 px-8">
    @foreach ($vgSupports as $vgSupport)
        <div class="inline-flex">
            <x-Form.Checkbox class="mr-2 mt-1 filter-vg-support" name="vg_support_{{ $vgSupport->id }}">checked</x-Form.Checkbox>
            <x-Form.Label for="vg-support-{{ $vgSupport->id }}">{{ $vgSupport->alias }}</x-Form.Label>
        </div>
    @endforeach
</div>