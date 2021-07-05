<div class="w-2/3">
    <x-form.label for="product_bought_offer_id_{{ $nb }}" block required>Offre</x-form.label>
    <select name="product_bought_offer_id_{{ $nb }}" id="product_bought_offer_id_{{ $nb }}" class="dynamic_select_data pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
        @foreach($offers as $offer)
            <option id="product_bought_offer_id_{{ $nb }}_{{ $offer->id }}" value="{{ $offer->id }}" @if(old('product_bought_offer_id_'.$nb) == $offer->id) selected @endif>{{ $offer->website->label.' - '.$offer->price.'€' }}</option>
        @endforeach
    </select>
    @error('product_bought_offer_id_'.$nb)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="w-1/3">
    <x-form.label for="product_bought_state_id_{{ $nb }}" block required>Etat du produit</x-form.label>
    <select name="product_bought_state_id_{{ $nb }}" id="product_bought_state_id_{{ $nb }}" data-nb="{{ $nb }}" class="dynamic_select_data pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
        @foreach($product_states as $product_state)
            <option id="product_bought_state_id_{{ $nb }}_{{ $product_state->id }}" value="{{ $product_state->id }}" @if(old('product_bought_state_id_'.$nb) == $product_state->id) selected @endif>{{ $product_state->label }}</option>
        @endforeach
    </select>
    @error('product_bought_state_id_'.$nb)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>