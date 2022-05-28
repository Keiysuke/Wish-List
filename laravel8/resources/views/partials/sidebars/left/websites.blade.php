<div class="sidebar_content text-sm" id="left_sidebar_websites">
    <p><x-svg.star class="icon-sm text-yellow-400"/> Mes sites préférés</p>
    <div class="ls_grid-3">
        @foreach($user_websites as $w)
            <div class="square">
                <a href="{{ $w->website->url }}" title="{{ $w->website->label }}" target="_blank"><img src="{{ asset(config('images.icons_websites')).'/'.$w->website->id.'.'.$w->website->icon }}"/></a>
            </div>
        @endforeach
        <div class="square dashed">
            +
        </div>
    </div>
    <p class="ls_title mt-12"><x-svg.globe class="icon-sm text-orange-400"/> Mes applis</p>
    <div class="ls_grid-3">
        <div class="square bg-white">
            <a href="http://localhost/00-Petits_projets/00-sommaire/" title="Mes applis" target="_blank"><img src="{{ asset(config('images.icons_mes_applis')).'/mes_applis.png' }}"/></a>
        </div>
        <div class="square bg-white">
            <a href="http://localhost/00 - API/warframe/laravel8/public/weapons" title="Warframe Codex" target="_blank"><img src="{{ asset(config('images.icons_mes_applis')).'/warframe.png' }}"/></a>
        </div>
    </div>
    <p class="ls_title mt-12"><x-svg.globe class="icon-sm text-green-400"/> Divers</p>
    <div class="ls_grid-3">
        <div class="square bg-white">
            <a href="https://www.leboncoin.fr/compte/part/mes-annonces" title="Mes ventes" target="_blank"><img src="{{ asset(config('images.icons_externals')).'/leboncoin.png' }}"/></a>
        </div>
        <div class="square">
            <a href="https://my.aliexpress.com/wishlist/wish_list_product_list.htm?spm=a2g0s.8937460.0.0.816c2e0exoRF4G" title="Mes Favoris" target="_blank"><img src="{{ asset(config('images.icons_websites')).'/7.jpg' }}"/></a>
        </div>
        <div class="square">
            <a href="https://www.twitch.tv/rocketleague" title="RL Twitch" target="_blank"><img src="{{ asset(config('images.icons_externals')).'/twitch_rl.png' }}"/></a>
        </div>
    </div>
</div>