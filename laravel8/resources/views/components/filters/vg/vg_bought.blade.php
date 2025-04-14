<p class="w-full text-center px-4 border-b-only border-gray-300 bg-gray-200 font-semibold p-1">Jeux Vidéo achetés</p>
<div class="grid grid-cols-2 gap-2 gap-x-12 px-8">
    <x-filters.utils.radio name="purchased" value="purchased_all" checked>Tous</x-filters.utils.radio>
    <x-filters.utils.radio name="purchased" value="purchased_yes">Achetés</x-filters.utils.radio>
    <x-filters.utils.radio name="purchased" value="purchased_no">Pas achetés</x-filters.utils.radio>
    <x-filters.utils.radio name="purchased" value="resold">Re/vendus</x-filters.utils.radio>
</div>