<div class="sidebar_content text-sm" id="left_sidebar_websites">
    @foreach($user_website_sections as $section_label => $user_websites)
        <p><x-svg.star class="icon-sm text-yellow-400"/> {{ $section_label }}</p>
        <div class="ls_grid-3">
            @foreach($user_websites as $w)
                <div class="square">
                    <a href="{{ $w->website->url }}" title="{{ $w->website->label }}" target="_blank"><img src="{{ asset(config('images.icons_websites')).'/'.$w->website->id.'.'.$w->website->icon }}"/></a>
                </div>
            @endforeach
        </div>
    @endforeach
    <p><x-svg.globe class="icon-sm text-orange-400"/> Mes applis</p>
    <div class="ls_grid-3">
        <div class="square bg-white">
            <a href="http://localhost/00-Petits_projets/00-sommaire/" title="Mes applis" target="_blank"><img src="{{ asset(config('images.icons_mes_applis')).'/mes_applis.png' }}"/></a>
        </div>
        <div class="square bg-white">
            <a href="http://localhost/00 - API/warframe/laravel8/public/weapons" title="Warframe Codex" target="_blank"><img src="{{ asset(config('images.icons_mes_applis')).'/warframe.png' }}"/></a>
        </div>
        <div class="square bg-white">
            <a href="http://localhost/00-Petits_projets/0-les_series" title="Renommer ses fichiers" target="_blank"><img src="{{ asset(config('images.icons_mes_applis')).'/les_series.png' }}"/></a>
        </div>
    </div>
</div>