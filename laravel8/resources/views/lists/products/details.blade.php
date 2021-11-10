<div class="flex flex-col gap-6" id="list_products">
    @if(count($products) > 0)
        @foreach($products as $product)
            @php($offer = $product->bestWebsiteOffer())
            <div class="list_product flex justify-between h-full border rounded hover:shadow-lg transition ease-in-out duration-150" id="list_{{ isset($list)? $list->id : '' }}_product_{{ $product->id }}">
                <div class="relative w-1/12 {{ ($product->nb_offers > 0)? '' : 'no-offer' }}">
                    <a href="{{ route('products.show', $product->id) }}">
                        <div class="product_pict rounded rounded-r-none" style="background-image: url({{ asset(config('images.path_products').'/'.$product->id.'/'.$product->photos()->firstWhere('ordered', 1)->label) }})"></div>
                    </a>
                </div>
                <div class="flex flex-col w-11/12 {{ ($product->nb_offers > 0)? ($product->can_buy? '' : 'offer-soon' ) : 'no-offer' }}">
                    <div class="flex inline-flex p-1 border-b border-gray-300 bg-gray-200 rounded">
                        <p class="text-xs w-full font-semibold text-black">{{ $product->label }}<span class="ml-2 text-sm text-blue-500">x {{ $product->nb }}</span></p>
                        <div class="icons_container">
                            <a href="{{ route('products.show', $product->id) }}" class="inline-flex hover:text-blue-500" title="Fiche du produit">
                                <x-svg.eye_open class="icon-xs"/>
                            </a>
                            @if(isset($list))
                                <a class="inline-flex hover:text-red-600 cursor-pointer" title="Enlever de la liste" onClick="if(confirm('Supprimer de la liste ?')){ toggle_list({{ $list->id }}, {{ $product->id }}); }">
                                    <x-svg.close class="icon-xs"/>
                                </a>
                            @endif
                        </div>
                    </div>
                    <p class="italic py-2 px-3 text-xs mb-1">{{ $product->description }}</p>
                    <div class="flex h-full items-end text-xs px-3">
                        <div class="flex pb-1">
                            <p class="flex inline-flex gap-2 font-semibold">Prix : <span class="font-normal text-{{ $offer['color'] }}-400">{{ $offer['price'] }} €</span>
                                <x-svg.external_link href="{{ $offer['url'] }}" target="_blank" class="icon-xs icon-clickable text-blue-400"/>
                            </p>
                            <x-utils.v_line height="4" />
                            <p class="font-semibold">Edition limitée : <span class="font-normal">{{ is_null($product->limited_edition)? 'Non' : $product->limited_edition.' ex.' }}</span></p>
                            <x-utils.v_line height="4" />
                            <x-products.bought_details :product="$product"/>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        Aucun produit trouvé...
    @endif
</div>

@if(count($products) > 0)
    <footer id="paginate" class="card-footer flex justify-center p-4">
        {{ $products->links() }}
    </footer>
@endif