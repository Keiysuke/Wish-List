<div class="grid grid-cols-4 gap-4" id="list-video-games">
    @if(count($videoGames) > 0)
        @foreach($videoGames as $videoGame)
            @php($product = $videoGame->product())
            <div class="list_video_game flex justify-between h-full shadow border rounded hover:shadow-lg transition ease-in-out duration-150">
                <div class="relative w-1/3">
                    <a href="{{ route('video_games.show', $videoGame->id) }}">
                        <div class="video-game-img rounded rounded-r-none" style="height: 10rem; background-image: url({{ $videoGame->pict }})"></div>
                    </a>
                </div>
                <div class="flex flex-col w-2/3">
                    <p class="relative flex items-center font-semibold text-black py-1 pl-4 border-b border-gray-300 bg-gray-200">
                        {{ $videoGame->label }}
                    </p>
                    <p class="p-2 pb-0 text-sm"><b>Studio :</b> {!! $videoGame->getStudioAsLink() !!}</p>
                    @php($desc = \App\Http\Controllers\UtilsController::cutString($videoGame->description(), 120))
                    <p class="italic p-2 text-sm">{!! nl2br($desc) !!}</p>
                </div>
            </div>
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