<div class="flex flex-col">
    <div class="user_avatar">{{ $user->name[0] }}</div>
    {{ $user->name }}
</div>
<div class="flex gap-4">
    @if($user->is_friend)
        <x-svg.user_minus id="delete_friend" class="icon-sm" data-id="{{ $user->id }}"/>
    @else
        <x-svg.user_plus id="add_friend" class="icon-sm" data-id="{{ $user->id }}"/>
    @endif
</div>