<x-form.label for="product_bought_purchase_id_{{ $nb }}" block required>Achat</x-form.label>
<select name="product_bought_purchase_id_{{ $nb }}" id="product_bought_purchase_id_{{ $nb }}" class="dynamic_select_data pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
    @foreach($purchases as $purchase)
        <option class="relative" id="product_bought_purchase_id_{{ $nb }}_{{ $purchase->id }}" value="{{ $purchase->id }}" @if(old('product_bought_purchase_id_'.$nb) == $purchase->id) selected @endif>
            {{ '#'.$purchase->id.' du '.date('d/m/Y', strtotime($purchase->date)).' - '.$purchase->cost.'€' }}
        </option>
    @endforeach
</select>
@error('product_bought_purchase_id_'.$nb)
    <div class="invalid-feedback">{{ $message }}</div>
@enderror