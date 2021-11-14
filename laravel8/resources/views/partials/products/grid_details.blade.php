<div class="grid md:grid-cols-3 lg:grid-cols-5 gap-6" id="grid_products">
    @if(count($products) > 0)
        @foreach($products as $product)
            <a href="{{ route('products.show', $product->id) }}">
                <div class="grid_product flex flex-col justify-between shadow border rounded h-full transform hover:-rotate-3 hover:shadow-xl transition ease-in-out duration-150">
                    <div class="top relative {{ ($product->nb_offers > 0)? '' : 'no-offer' }}">
                        <div class="product_price">{{ $product->real_cost }} €</div>
                        <div class="product_pict rounded rounded-b-none" style="background-image: url({{ asset(config('images.path_products').'/'.$product->id.'/'.$product->photos()->firstWhere('ordered', 1)->label) }})"></div>
                    </div>
                    <div class="down flex flex-col justify-between h-full font-semibold text-center {{ ($product->nb_offers > 0)? ($product->can_buy? '' : 'offer-soon' ) : 'no-offer' }}">
                        <p class="my-2 text-black">{{ (strlen($product->label) > 50)? substr($product->label, 0, 50).'...' : $product->label }}</p>
                        
                        <x-products.tags_details class="mb-2 justify-center" :tags="$product->tags"/>
                        
                        <div class="flex justify-end items-end">
                            @if($product->archived)
                                <x-svg.archive class="icon-sm absolute left-1 bottom-1 text-yellow-700"/>
                            @endif
                            <p class="text-xs bg-gray-800 text-white p-2">
                                @if($product->nb_offers > 0 && !$product->can_buy)
                                    <svg class="h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @endif
                                {{ $product->date_show }}
                            </p>
                        </div>
                    </div>
                </div>
            </a>
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