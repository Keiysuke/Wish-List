<div class="flex flex-col gap-4" id="list_products">
    @if(count($products) > 0)
        @foreach($products as $product)
            <div class="list_product flex justify-between h-full shadow border rounded hover:shadow-lg transition ease-in-out duration-150">
                <div class="relative w-1/5 {{ ($product->nb_offers > 0)? '' : 'no-offer' }}">
                    <a href="{{ route('products.show', $product->id) }}">
                        <div class="product_price">{{ $product->real_cost }} €</div>
                        <div class="product_pict rounded rounded-r-none" style="height: 11rem; background-image: url({{ asset(config('images.path_products').'/'.$product->id.'/'.$product->photos()->firstWhere('ordered', 1)->label) }})"></div>
                    </a>
                </div>
                <div class="flex flex-col w-4/5 {{ ($product->nb_offers > 0)? ($product->can_buy? '' : 'offer-soon' ) : 'no-offer' }}">
                    <p class="relative flex items-center text-lg font-semibold text-black py-1 pl-4 border-b border-gray-300 bg-gray-200">
                        {{ $product->label }}
                        @if($product->archived)
                            <x-svg.archive class="icon-sm absolute right-3 text-yellow-700"/>
                        @endif
                    </p>
                    <p class="italic py-2 px-4 text-sm">{{ $product->description }}</p>
                    <div class="flex h-full px-4">
                        <div class="flex items-end w-4/5 pb-4">
                            <p class="font-semibold">Edition limitée : <span class="font-normal">{{ is_null($product->limited_edition)? 'Non' : $product->limited_edition.' ex.' }}</span></p>
                            <x-utils.v_line />
                            <x-products.bought_details :product="$product"/>
                            {{-- <p class="text-xs text-gray-400">{{ (count($product->purchases) >= 1)? 'Acheté le '.date('d/m/Y', strtotime($product->purchases()->orderBy('date')->first()->date)) : 'Pas acheté' }}</p> --}}
                        </div>
                        
                        <div class="flex w-1/5 justify-end items-center mr-2">
                            <a href="{{ route('products.show', $product->id) }}" class="btn_show_product inline-flex text-white">
                                <p class="bg-blue-500 px-8 py-2">Voir</p>
                                <div class="flex items-center px-2 bg-blue-400">
                                    <x-svg.big.arrow class="icon-sm"/>
                                </div>
                            </a>
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