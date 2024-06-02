<p class="relative w-full text-center px-4 border-b-only border-gray-300 bg-gray-200 font-semibold p-1">Choix de la période</p>
<div class="flex justify-center gap-2">
    <div class="flex inline-flex items-center gap-2">
        <x-Form.Label for="from">Du</x-Form.Label>
        <x-Form.Date name="date_from">{{ old("date_from") }}</x-Form.Date>
    </div>
    <div class="inline-flex items-center gap-2">
        <x-Form.Label for="from">au</x-Form.Label>
        <x-Form.Date name="date_to">{{ old("date_to") }}</x-Form.Date>
    </div>
</div>