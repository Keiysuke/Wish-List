<div class="grid md:grid-cols-4 lg:grid-cols-8 gap-6" id="grid_video_games">
    @if(count($video_games) > 0)
        @foreach($video_games as $video_game)
            @php($product = $video_game->product())
            @php($photo = is_null($product)? asset('resources/images/no_pict.png') : asset(config('images.path_products').'/'.$product->id.'/'.$product->photos()->firstWhere('ordered', 1)->label))
            <a href="{{ route('video_games.show', $video_game->id) }}">
                <div class="grid_video_game flex flex-col justify-between shadow border rounded h-full transform hover:-rotate-3 hover:shadow-xl transition ease-in-out duration-150">
                    <div class="top relative">
                        <div class="video_game_price">{{ is_null($product)? '??' : $product->real_cost }} €</div>
                        <div class="video_game_pict rounded rounded-b-none" style="background-image: url({{ $photo }})"></div>
                    </div>
                    <div class="down flex flex-col justify-between h-full font-semibold text-center">
                        <p class="my-2 text-black">{{ (strlen($video_game->label) > 50)? substr($video_game->label, 0, 50).'...' : $video_game->label }}</p>
                        
                        <div class="flex justify-end items-end">
                            <p class="text-xs bg-gray-800 text-white p-2">
                                <x-svg.big.clock class="icon-xs"/>
                            </p>
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    @else
        Aucun jeu vidéo trouvé...
    @endif
</div>

@if(count($video_games) > 0)
    <footer id="paginate" class="card-footer flex justify-center p-4">
        {{ $video_games->links() }}
    </footer>
@endif