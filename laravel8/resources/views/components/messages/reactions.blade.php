@php($users = 0)
@foreach ($reactions->getReactions() as $emoji_id => $reaction)
    <x-messages.reaction :r="$reaction"/>
    @php($users += count($reaction->users))
@endforeach

@if ($users > 0)
    <span>{{ $users }}</span>
@endif