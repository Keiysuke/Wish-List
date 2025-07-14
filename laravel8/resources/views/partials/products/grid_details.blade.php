<div class="grid md:grid-cols-3 lg:grid-cols-5 gap-6" id="grid-products">
    @if(count($products) > 0)
        @foreach($products as $product)
        @php($crowdfunding = $product->firstCrowdfunding())
        <div class="wrap-grid-product">
            <a href="{{ route('products.show', $product->id) }}">
                <div class="grid-product flex flex-col justify-between shadow border rounded h-full">
                    <div class="top relative {{ ($product->nb_offers > 0)? '' : 'no-offer' }}">
                        <div class="product-price">{{ $product->real_cost }} €</div>
                        <div class="product-pict rounded rounded-b-none" style="background-image: url({{ $product->pict }})"></div>
                    </div>
                    <div class="down flex flex-col justify-between h-full font-semibold text-center {{ ($product->nb_offers > 0)? ($product->can_buy? '' : 'offer-soon' ) : 'no-offer' }}">
                        <p class="my-2 text-black">{{ (strlen($product->label) > 50)? substr($product->label, 0, 50).'...' : $product->label }}</p>
                        
                        <x-products.tags_details class="mb-2 justify-center" :tags="$product->tags"/>
                        
                        <div class="flex justify-end items-end">
                            @if($product->isArchived())
                                <x-svg.archive class="icon-sm absolute left-1 bottom-1 text-yellow-700"/>
                            @endif
                            <div class="flex gap-2 text-xs">
                                {!! $product->renderStateIcon() !!}
                                <p class="bg-{{ $product->bought ? 'green-600' : 'gray-800' }} text-white p-2">
                                    {{ $product->date_show }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            @if($crowdfunding)
                <div class="top cfg-icons">
                    <x-Utils.TitleIcon.Cfg :cfg="$product->firstCrowdfunding()"/>
                </div>
            @elseif($product->video_game)
                @php($vg = $product->video_game->video_game)
                @php($support = $product->video_game->vg_support)
                <div class="top vg-icons">
                    <x-Utils.TitleIcon.Vg id="{{ $product->video_game->video_game_id }}"/>
                    <x-Utils.TitleIcon.Yt search="{{ $vg->label }} Soundtrack"/>
                    <x-Utils.TitleIcon.Psthc search="{{ $vg->label }}" :support="$support"/>
                </div>
            @elseif($product->book)
                @php($book = $product->book)
                <div class="top book-icons">
                    <x-Utils.TitleIcon.Book id="{{ $book->id }}"/>
                    <x-products.search_opinion id="icon-find-opinion" search="{{ $product->label }}"/>
                </div>
            @endif
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