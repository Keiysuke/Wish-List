@if (isset($item) && isset($friends))
    <div class="pointer-events-auto h-4/6 w-1/4 p-4 z-30 border bg-gray-200 border-gray-800">
        <div class="flex flex-col justify-around items-center h-full gap-2">
            @if (count($friends) > 0)
                <h2>Partager ma liste à :</h2>
                <div id="scroll-friends" class="h-5/6 px-1 overflow-x-hidden overflow-y-auto overscroll-contain scrollbar-thin scrollbar-thumb-red-500 scrollbar-track-red-200 scrollbar-thumb-rounded">
                    @foreach ($friends as $friend)
                    <div>
                        <x-Form.Checkbox class="mr-1" name="share_friend_{{ $friend->id }}" data-friend-id="{{ $friend->id }}"/>
                        <label for="share-friend-{{ $friend->id }}">{{ $friend->name }}</label>
                    </div>
                    @endforeach
                </div>
            @else
                <span class="flex flex-col items-center gap-2">
                    Vous avez déjà invité tous vos amis à rejoindre cette liste.
                    <a class="link "href="{{ route('myFriends') }}">Ajouter plus d'amis ?</a>
                </span>
            @endif
            <div class="flex items-center justify-center gap-4">
                @if (count($friends) > 0)
                    <x-Form.Btn onClick="share({{ $item->id }})">Partager</x-Form.Btn>
                @endif
                <x-Form.Cancel onClick="toggleShare({{ $type }});"/>
            </div>
        </div>
    </div>
@endif