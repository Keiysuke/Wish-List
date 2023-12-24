
@php($kind = $kind ?? 'products')
<p class="w-full text-center px-4 border-b-only border-gray-300 bg-gray-200 font-semibold p-1">Produits achetés</p>
<div class="grid grid-cols-{{ ($kind === 'products') ? 4 : 2 }} gap-2 gap-x-12 px-8">
    @if($kind === 'products')
        <x-filters.utils.radio name="purchased" value="purchased_all" checked>Tous</x-filters.utils.radio>
        <x-filters.utils.radio name="purchased" value="purchased_yes">Achetés</x-filters.utils.radio>
        <x-filters.utils.radio name="purchased" value="purchased_no">Pas achetés</x-filters.utils.radio>
        <x-filters.utils.radio name="purchased" value="not_received">Pas reçu</x-filters.utils.radio>
        <x-filters.utils.radio name="purchased" value="selling">En vente</x-filters.utils.radio>
        <x-filters.utils.radio name="purchased" value="resold">Re/vendus</x-filters.utils.radio>
        <x-filters.utils.radio name="purchased" value="discount">En réduction</x-filters.utils.radio>
        <x-filters.utils.radio name="purchased" value="free">Gratuits</x-filters.utils.radio>
    @else
        <x-filters.utils.radio name="purchased" value="purchased_all">Tous</x-filters.utils.radio>
        <x-filters.utils.radio name="purchased" value="purchased_yes">Achetés</x-filters.utils.radio>
        <x-filters.utils.radio name="purchased" value="selling">En vente</x-filters.utils.radio>
        <x-filters.utils.radio name="purchased" value="resold" checked>Re/vendus</x-filters.utils.radio>
    @endif
</div>