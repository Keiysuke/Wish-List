<div class="relative w-full text-center px-4 border-b-only border-gray-300 bg-gray-200 font-semibold p-1">
    <div class="flex inline-flex gap-2 absolute top-2 left-2 text-xs">
        <label for="no-tag">Aucun <input class="ml-1" id="no-tag" name="no_tag" type="checkbox"/></label>
        <label for="exclusive-tags">Exclusif <input class="ml-1" id="exclusive-tags" name="exclusive_tags" type="checkbox"/></label>
    </div>
    Tags
    <label class="absolute top-2 right-2 text-xs">Dé/cocher tout <input class="ml-1" id="check-all-tags" type="checkbox" checked/></label>
</div>
<div class="grid grid-cols-{{ (count($tags) >= 12)? 4 : 3 }} gap-x-12 gap-y-2 px-8">
    @foreach ($tags as $tag)
        <div class="inline-flex">
            <x-Form.Checkbox class="mr-2 mt-1 filter-tag" name="tag_{{ $tag->id }}" :check="$filters->tag_in"></x-Form.Checkbox>
            <x-Form.Label for="tag-{{ $tag->id }}"><x-Tags.Tag :tag="$tag"/></x-Form.Label>
        </div>
    @endforeach
</div>