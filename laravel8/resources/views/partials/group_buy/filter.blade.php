<div id="content_filters" class="flex flex-col items-start gap-4 hidden">
    <div class="filter_block flex flex-col items-center gap-2">
        <p class="relative w-full text-center px-4 border-b-only border-gray-300 bg-gray-200 font-semibold p-1">Choix de la période</p>
        <div class="flex justify-center gap-2">
            <div class="flex inline-flex items-center gap-2">
                <x-form.label for="from">Du</x-form.label>
                <x-form.date name="date_from">{{ old("date_from") }}</x-form.date>
            </div>
            <div class="inline-flex items-center gap-2">
                <x-form.label for="from">au</x-form.label>
                <x-form.date name="date_to">{{ old("date_to") }}</x-form.date>
            </div>
        </div>
    </div>
    <div class="w-full flex justify-center">
        <button type="submit" class="w-1/6 p-2 rounded text-white bg-blue-500 hover:bg-blue-400">Appliquer les filtres</button>
    </div>
</div>