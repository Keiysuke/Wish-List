<div class="sidebar_content text-sm" id="left_sidebar_websites">
    <p><x-svg.star class="icon-sm text-yellow-400"/> Mes sites préférés</p>
    <div id="ls_favorites">
        @foreach($user_websites as $w)
            <div class="square">
                <a href="{{ $w->website->url }}" title="{{ $w->website->label }}" target="_blank"><img src="{{ asset(config('images.path_websites_icons')).'/'.$w->website->id.'.'.$w->website->icon }}"/></a>
            </div>
        @endforeach
        <div class="square dashed">
            +
        </div>
    </div>
    <p class="ls_title mt-12"><x-svg.globe class="icon-sm text-orange-400"/> Mes applis</p>
    <div id="ls_mes_applis">
        <div class="square bg-white">
            <a href="http://localhost/00-Petits_projets/00-sommaire/" title="Mes applis" target="_blank"><img src="{{ asset(config('images.path_mes_applis_icons')).'/mes_applis.png' }}"/></a>
        </div>
        <div class="square bg-white">
            <a href="http://localhost/00 - API/warframe/laravel8/public/weapons" title="Warframe Codex" target="_blank"><img src="{{ asset(config('images.path_mes_applis_icons')).'/warframe.png' }}"/></a>
        </div>
    </div>
</div>