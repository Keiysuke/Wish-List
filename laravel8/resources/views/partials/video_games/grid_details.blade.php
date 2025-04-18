<div class="grid md:grid-cols-4 lg:grid-cols-8 gap-6" id="grid-video-games">
    @if(count($videoGames) > 0)
        @foreach($videoGames as $videoGame)
            @php($product = $videoGame->product())
            <a href="{{ route('video_games.show', $videoGame->id) }}">
                <div class="grid_video_game flex flex-col justify-between shadow border rounded h-full transform hover:-rotate-3 hover:shadow-xl transition ease-in-out duration-150">
                    <div class="top relative">
                        <div class="video-game-price">{{ is_null($product)? '??' : $product->real_cost }} €</div>
                        <div class="video-game-img rounded rounded-b-none" style="background-image: url({{ $videoGame->pict }})"></div>
                    </div>
                    <div class="down flex flex-col justify-between h-full font-semibold text-center">
                        @php($label = \App\Http\Controllers\UtilsController::cutString($videoGame->label, 50))
                        <p class="my-2 text-black">{{ $label }}</p>
                        
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

@if(count($videoGames) > 0)
    <footer id="paginate" class="card-footer flex justify-center p-4">
        {{ $videoGames->links() }}
    </footer>
@endif