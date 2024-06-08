<div id="content-img-zoomed" class="absolute flex justify-center items-center w-full h-full hidden" onClick="toggleZoomPictures();">
    <div class="flex justify-between items-center gap-1 fixed w-2/3 h-4/5 z-30 border bg-gray-200 border-gray-800">
        <div class="flex flex-col w-full h-full">
            <!-- <div class="flex justify-center items-center border-b-only border-gray-800" style="height:7%;">Options</div> 
            <div class="flex" style="height:93%;"> -->
            <div class="flex h-full">
                <div class="flex justify-center items-center w-11/12 h-full p-4">
                    <img id="img-zoom-main" class="max-w-full max-h-full" src="{{ $firstPhoto }}"/>
                </div>
                <input type="hidden" id="nb-max-pict" value="{{ count($photos) }}"/>
                <div class="grid grid-cols justify-center content-start gap-1 w-1/12 h-full border-l border-gray-800 pointer-events-auto overflow-x-hidden overflow-y-auto overscroll-contain scrollbar-thin scrollbar-thumb-red-500 scrollbar-track-red-200 scrollbar-thumb-rounded">
                    @foreach ($photos as $photo)
                        <div class="max-w-full max-h-full cursor-pointer border-b border-gray-800 hover:opacity-70" onClick="showPict({{ @++$i }});"><img id="img-zoom-sec{{ $i }}" src="{{ asset($dir.$photo->label) }}"/></div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>