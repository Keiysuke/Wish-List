@php($first = $product ?? $products->first())
@php($first->setFirstPhoto())
@php($existingPurchase = old('product_bought_exists_'.$nb, ($editPurchase->id ?? null)))
<div id="product-bought-{{ $nb }}">
    <div class="flex gap-4">
        <div class="flex flex-col gap-1 justify-center items-center inline left-0">
            <x-Form.Checkbox name="product_bought_delete_{{ $nb }}"></x-Form.Checkbox>
            <x-Form.Label for="product-bought-delete-{{ $nb }}">
                <x-svg.trash class="icon-xs"/>
            </x-Form.Label>
        </div>
        <div class="flex justify-center w-1/12">
            <a href="{{ route('products.show', $first->id) }}" target="_blank" id="product-link-{{ $nb }}">
                <img id="img-product-bought-{{ $nb }}" class="h-20" src="{{ $first->pict }}"/>
            </a>
        </div>
        <div class="w-6/12">
            <x-Form.Label for="product-bought-id-{{ $nb }}" block required class="relative">
                Produit acheté
                
                <div class="absolute inline right-0">
                    <x-Form.Checkbox name="product_bought_exists_{{ $nb }}" onChange="handleExistingBuy(this, {{ $nb }})">{{ $existingPurchase? 'checked' : '' }}</x-Form.Checkbox>
                    <x-Form.Label class="ml-1" for="product-bought-exists-{{ $nb }}">Achat existant ?</x-Form.Label>
                </div>
            </x-Form.Label>
            <select name="product_bought_id_{{ $nb }}" id="product-bought-id-{{ $nb }}" data-nb="{{ $nb }}" class="product-bought dynamic-selected-product pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                @foreach($products as $product)
                    <option id="product-bought-id-{{ $nb }}_{{ $product->id }}" value="{{ $product->id }}" @if(old('product_bought_id_'.$nb, $first->id) == $product->id) selected @endif>{{ $product->label }}</option>
                @endforeach
            </select>
            @error('product_bought_id_'.$nb)
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="w-6/12 {{ $existingPurchase? '' : 'hidden' }}" id="product-bought-purchase-{{ $nb }}">
            @include('partials.group_buy.select_purchase', ['nb' => $nb, 'purchases' => $first->purchases, 'editPurchase' => ($editPurchase ?? null)])
        </div>

        <div class="flex gap-4 w-4/12 {{ $existingPurchase? 'hidden' : '' }}" id="product-bought-offer-{{ $nb }}">
            @include('partials.group_buy.select_offer', ['nb' => $nb, 'offers' => $first->productWebsites])
        </div>

        <div class="w-1/12 {{ $existingPurchase? 'hidden' : '' }}" id="div-product-bought-nb-{{ $nb }}">
            <x-Form.Label block for="product-bought-nb-{{ $nb }}">Acheté(s)</x-Form.Label>
            <select name="product_bought_nb_{{ $nb }}" id="product-bought-nb-{{ $nb }}" class="dynamic-selected-product pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                @for ($i = 1; $i <= 10; $i++)
                    <option id="product-bought-nb-{{ $nb }}-{{ $i }}" value="{{ $i }}" @if(old('product_bought_nb_'.$nb) == $i) selected @endif>{{ $i }}</option>
                @endfor
            </select>
            @error('product_bought_nb_'.$nb)
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="w-1/12 {{ $existingPurchase? 'hidden' : '' }}" id="product-bought-discount-{{ $nb }}">
            <x-Form.Label for="product-bought-discount-{{ $nb }}" block>Réduction (€)</x-Form.Label>
            <x-Form.Input name="product_bought_discount_{{ $nb }}" placeholder="0" value="{{ old('product_bought_discount_'.$nb) }}"/>
        </div>

        <div class="w-1/12 {{ $existingPurchase? 'hidden' : '' }}" id="product-bought-customs-{{ $nb }}">
            <x-Form.Label for="product-bought-customs-{{ $nb }}" block>Douane (€)</x-Form.Label>
            <x-Form.Input name="product_bought_customs_{{ $nb }}" placeholder="0" value="{{ old('product_bought_customs_'.$nb) }}"/>
        </div>
    </div>
</div>