@foreach ($friends as $friend)
    <div id="sb-friend-row-{{ $friend->id }}" class="friend-row" data-id="{{ $friend->id }}">
        <div class="avatar">
            {{ $friend->first_letter }}
        </div>
        <div class="name">
            {{ $friend->name }}
        </div>
    </div>
@endforeach