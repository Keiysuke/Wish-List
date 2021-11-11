<div class="flex inline-flex gap-2">
@foreach($tags as $tag)
    <x-tags.tag :tag="$tag" />
@endforeach
</div>