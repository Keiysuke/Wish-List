<p class="w-full text-center px-4 border-b-only border-gray-300 bg-gray-200 font-semibold p-1">Stock des produits</p>
<div class="grid grid-cols-3 gap-2 gap-x-12 px-8">
    <x-filters.utils.radio name="stock" value="product_all" checked>Tous</x-filters.utils.radio>
    <x-filters.utils.radio name="stock" value="product_available" :checked="$filters->stock">Disponibles</x-filters.utils.radio>
    <x-filters.utils.radio name="stock" value="product_to_come" :checked="$filters->stock">A venir</x-filters.utils.radio>
    <x-filters.utils.radio name="stock" value="product_expired" :checked="$filters->stock">Expirés</x-filters.utils.radio>
    <x-filters.utils.radio name="stock" value="product_missing" :checked="$filters->stock">Manquantes</x-filters.utils.radio>
</div>