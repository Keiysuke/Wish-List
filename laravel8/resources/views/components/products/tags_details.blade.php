<div class="flex inline-flex gap-2 {{ $class ?? '' }}">
    @php($i = 1)
@foreach($tags as $tag)
    @if(!($i++ % 4))
        </div>
        <div class="flex inline-flex gap-2 {{ $class ?? '' }}">
    @endif
    <x-Tags.Tag :tag="$tag" />
@endforeach
</div>