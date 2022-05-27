<div class="grid grid-cols-4 gap-4" id="list_video_games">
    @if(count($video_games) > 0)
        @foreach($video_games as $video_game)
            @php($product = $video_game->product())
            @php($photo = is_null($product)? asset('resources/images/no_pict.png') : asset(config('images.path_products').'/'.$product->id.'/'.$product->photos()->firstWhere('ordered', 1)->label))
            <div class="list_video_game flex justify-between h-full shadow border rounded hover:shadow-lg transition ease-in-out duration-150">
                <div class="relative w-1/3">
                    <a href="{{ route('video_games.show', $video_game->id) }}">
                        <div class="video_game_pict rounded rounded-r-none" style="height: 10rem; background-image: url({{ $photo }})"></div>
                    </a>
                </div>
                <div class="flex flex-col w-2/3">
                    <p class="relative flex items-center font-semibold text-black py-1 pl-4 border-b border-gray-300 bg-gray-200">
                        {{ $video_game->label }}
                    </p>
                </div>
            </div>
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