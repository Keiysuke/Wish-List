@if (isset($productList))
    <div class="pointer-events-auto h-4/6 w-1/4 p-4 z-30 border bg-gray-200 border-gray-800">
        <div class="flex flex-col justify-around items-center h-full gap-2">
            <label for="edit-product-list-nb">Quantité</label>
            <x-Form.Input type="hidden" name="edit-product-list-old-nb" value="{{ $productList->nb }}"/>
            <x-Form.Input name="edit-product-list-nb" value="{{ $productList->nb }}"/>
            <div class="flex items-center justify-center gap-4">
                <x-Form.Btn onClick="editProductList({{ $productList->listing_id }}, {{ $productList->product->id }})">Valider la quantité</x-Form.Btn>
                <x-Form.Cancel onClick="toggleEditProductList();"/>
            </div>
        </div>
    </div>
@endif