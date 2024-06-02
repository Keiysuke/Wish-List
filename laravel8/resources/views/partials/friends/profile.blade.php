<div class="flex flex-col">
    <div class="user-avatar">{{ $user->name[0] }}</div>
    {{ $user->name }}
</div>
<div class="flex gap-4">
    @if($user->isFriend)
        <x-svg.user_minus id="delete-friend" class="icon-sm" data-id="{{ $user->id }}"/>
    @else
        <x-svg.user_plus id="add-friend" class="icon-sm" data-id="{{ $user->id }}"/>
    @endif
</div>