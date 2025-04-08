<div class="sidebar-content" id="left-sidebar-publishers">
    <p><x-svg.globe class="icon-sm text-blue-400"/> Maisons d'édition</p>
    <div class="left-sidebar-grid-3">
        @foreach($lsbPublishers as $publisher)
            @php($website = $publisher->website)
            <div class="square">
                <a href="{{ $website->url }}" title="{{ $website->label }}" target="_blank">
                    <img src="{{ asset(config('images.icons_websites')).'/'.$website->id.'.'.$website->icon }}"/>
                </a>
            </div>
        @endforeach
    </div>
</div>