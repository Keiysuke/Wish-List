<div id="product-picture" class="flex {{ (count($photos) > 1)? 'justify-between' : 'justify-center' }} gap-2">
    <div id="picture-displayed" onMouseOver="onPicture(true);" onMouseOut="onPicture(false);" onClick="toggleZoomPictures(1);" class="relative {{ (count($photos) > 1)? 'flex w-4/5' : '' }}">
        <div class="flex justify-center items-center absolute h-full w-full">
            <x-svg.big.zoom_in id="big-img-zoom" class="w-20 hidden pointer-events-none"/>
        </div>
        <img id="big-img" class="cursor-pointer object-contain {{ count($photos) === 1 ? 'pr-1' : '' }}" src="{{ $firstPhoto }}"/>
    </div>
    @if(count($photos) > 1)
        <div class="flex flex-col w-1/5 gap-2 overflow-x-hidden overflow-y-auto overscroll-contain scrollbar-thin scrollbar-thumb-red-500 scrollbar-track-red-200 pr-1" style="height:450px;">
            @foreach ($photos as $photo)
                <div class="max-w-full max-h-full cursor-pointer hover:opacity-70" onClick="toggleZoomPictures({{ @++$i }});"><img id="product-pict_{{ $i }}" src="{{ asset($dir.$photo->label) }}" class="border border-gray-800"/></div>
            @endforeach
        </div>
    @endif
</div>