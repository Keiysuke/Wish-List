@foreach ($friends as $friend)
    <div class="friend_row" data-id="{{ $friend->id }}">
        <div class="avatar">
            {{ $friend->first_letter }}
        </div>
        <div class="name">
            {{ $friend->name }}
        </div>
    </div>
@endforeach