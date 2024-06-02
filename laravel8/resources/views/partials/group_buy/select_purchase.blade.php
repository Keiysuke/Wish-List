<x-Form.Label for="product-bought-purchase-id-{{ $nb }}" block required>
    Achat
</x-Form.Label>
<select 
    name="product_bought_purchase_id_{{ $nb }}" 
    id="product-bought-purchase-id-{{ $nb }}" 
    class="dynamic-selected-product pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent"
    >
    @foreach($purchases as $purchase)
        <option 
            class="relative" 
            id="product-bought-purchase-id-{{ $nb }}_{{ $purchase->id }}" 
            value="{{ $purchase->id }}" @if(old('product_bought_purchase_id_'.$nb, ($editPurchase->id ?? null)) == $purchase->id) selected @endif
            >
            {{ '#'.$purchase->id.' du '.date('d/m/Y', strtotime($purchase->date)).' - '.$purchase->cost.'€' }}
        </option>
    @endforeach
</select>
@error('product_bought_purchase_id_'.$nb)
    <div class="invalid-feedback">{{ $message }}</div>
@enderror