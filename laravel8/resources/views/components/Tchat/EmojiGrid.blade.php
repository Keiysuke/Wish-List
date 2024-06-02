@foreach ($section->emojis as $emoji)
    <x-Tchat.Emoji :emoji="$emoji"/>
@endforeach