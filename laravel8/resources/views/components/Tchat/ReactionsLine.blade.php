@php
    $usersCount = 0;
    $reactions = $reactions->getReactions();
@endphp

@foreach ($reactions as $emoji_id => $reaction)
    <x-Tchat.Reaction :r="$reaction"/>
    @php($usersCount += count($reaction->users))
@endforeach

@if ($usersCount > 0)
    <span>{{ $usersCount }}</span>
@endif