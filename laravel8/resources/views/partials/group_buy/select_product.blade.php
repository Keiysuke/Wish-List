@php($first = $product ?? $products->first())
@php($existing_purchase = old('product_bought_existing_'.$nb, ($edit_purchase->id ?? null)))
<div id="product_bought_{{ $nb }}">
    <div class="flex gap-4">
        <div class="flex flex-col gap-1 justify-center items-center inline left-0">
            <x-form.checkbox name="product_bought_delete_{{ $nb }}"></x-form.checkbox>
            <x-form.label for="product_bought_delete_{{ $nb }}">
                <x-svg.trash class="icon-xs"/>
            </x-form.label>
        </div>
        <div class="flex justify-center w-1/12">
            <a href="{{ route('products.show', $first->id) }}" target="_blank" id="product_link_{{ $nb }}">
                <img id="product_bought_img_{{ $nb }}" class="h-20" src="{{ asset(config('images.path_products').'/'.$first->id.'/'.$first->photos()->first()->label) }}"/>
            </a>
        </div>
        <div class="w-6/12">
            <x-form.label for="product_bought_id_{{ $nb }}" block required class="relative">
                Produit acheté
                
                <div class="absolute inline right-0">
                    <x-form.checkbox name="product_bought_existing_{{ $nb }}" onChange="handle_existing_buy(this, {{ $nb }})">{{ $existing_purchase? 'checked' : '' }}</x-form.checkbox>
                    <x-form.label class="ml-1" for="product_bought_existing_{{ $nb }}">Achat existant ?</x-form.label>
                </div>
            </x-form.label>
            <select name="product_bought_id_{{ $nb }}" id="product_bought_id_{{ $nb }}" data-nb="{{ $nb }}" class="product_bought dynamic_select_data pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                @foreach($products as $product)
                    <option id="product_bought_id_{{ $nb }}_{{ $product->id }}" value="{{ $product->id }}" @if(old('product_bought_id_'.$nb, $first->id) == $product->id) selected @endif>{{ $product->label }}</option>
                @endforeach
            </select>
            @error('product_bought_id_'.$nb)
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="w-6/12 {{ $existing_purchase? '' : 'hidden' }}" id="product_bought_purchase_{{ $nb }}">
            @include('partials.group_buy.select_purchase', ['nb' => $nb, 'purchases' => $first->purchases, 'edit_purchase' => ($edit_purchase ?? null)])
        </div>

        <div class="flex gap-4 w-4/12 {{ $existing_purchase? 'hidden' : '' }}" id="product_bought_offer_{{ $nb }}">
            @include('partials.group_buy.select_offer', ['nb' => $nb, 'offers' => $first->productWebsites])
        </div>

        <div class="w-1/12 {{ $existing_purchase? 'hidden' : '' }}" id="div_product_bought_nb_{{ $nb }}">
            <x-form.label block for="product_bought_nb_{{ $nb }}">Acheté(s)</x-form.label>
            <select name="product_bought_nb_{{ $nb }}" id="product_bought_nb_{{ $nb }}" class="dynamic_select_data pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                @for ($i = 1; $i <= 10; $i++)
                    <option id="product_bought_nb_{{ $nb }}_{{ $i }}" value="{{ $i }}" @if(old('product_bought_nb_'.$nb) == $i) selected @endif>{{ $i }}</option>
                @endfor
            </select>
            @error('product_bought_nb_'.$nb)
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="w-1/12 {{ $existing_purchase? 'hidden' : '' }}" id="product_bought_discount_{{ $nb }}">
            <x-form.label for="product_bought_discount_{{ $nb }}" block>Réduction (€)</x-form.label>
            <x-form.input name="product_bought_discount_{{ $nb }}" placeholder="0" value="{{ old('product_bought_discount_'.$nb) }}"/>
        </div>

        <div class="w-1/12 {{ $existing_purchase? 'hidden' : '' }}" id="product_bought_customs_{{ $nb }}">
            <x-form.label for="product_bought_customs_{{ $nb }}" block>Douane (€)</x-form.label>
            <x-form.input name="product_bought_customs_{{ $nb }}" placeholder="0" value="{{ old('product_bought_customs_'.$nb) }}"/>
        </div>
    </div>
</div>