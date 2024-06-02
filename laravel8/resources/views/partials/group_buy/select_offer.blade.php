<div class="w-2/3">
    <x-Form.Label for="product-bought-offer-id-{{ $nb }}" block required>Offre</x-Form.Label>
    <select name="product_bought_offer_id_{{ $nb }}" id="product-bought-offer-id-{{ $nb }}" class="dynamic-selected-product pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
        @foreach($offers as $offer)
            <option id="product-bought-offer-id-{{ $nb }}_{{ $offer->id }}" value="{{ $offer->id }}" @if(old('product_bought_offer_id_'.$nb) == $offer->id) selected @endif>{{ $offer->website->label.' - '.$offer->price.'€' }}</option>
        @endforeach
    </select>
    @error('product_bought_offer_id_'.$nb)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="w-1/3">
    <x-Form.Label for="product-bought-state-id-{{ $nb }}" block required>Etat du produit</x-Form.Label>
    <select name="product_bought_state_id_{{ $nb }}" id="product-bought-state-id-{{ $nb }}" data-nb="{{ $nb }}" class="dynamic-selected-product pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
        @foreach($productStates as $productState)
            <option id="product-bought-state-id-{{ $nb }}_{{ $productState->id }}" value="{{ $productState->id }}" @if(old('product_bought_state_id_'.$nb) == $productState->id) selected @endif>{{ $productState->label }}</option>
        @endforeach
    </select>
    @error('product_bought_state_id_'.$nb)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>