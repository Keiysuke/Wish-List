<span 
    @if(isset($id)) id="{{ $id }}" @endif 
    class="tag cursor-pointer border-{{ $tag->color('border') }} text-{{ $tag->color('text') }} bg-{{ $tag->color('bg') }}" 
    onClick="window.location='{{ route('myProducts', ['tag_in' => $tag->id]) }}'"
    >
    {{ $tag->label }}
</span>