<span @if(isset($id)) id="{{ $id }}" @endif class="tag border-{{ $tag->color('border') }} text-{{ $tag->color('text') }} bg-{{ $tag->color('bg') }}">
    {{ $tag->label }}
</span>