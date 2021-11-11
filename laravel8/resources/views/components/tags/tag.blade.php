<span @if(isset($id)) id="{{ $id }}" @endif class="tag border-{{ $tag->color() }} text-{{ $tag->color() }} @if($tag->color() === 'white') bg-gray-700 @endif">
    {{ $tag->label }}
</span>