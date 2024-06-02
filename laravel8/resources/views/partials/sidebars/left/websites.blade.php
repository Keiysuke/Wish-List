<div class="sidebar-content text-sm" id="left-sidebar-websites">
    @foreach($userWebsiteSections as $sectionId => $userWebsites)
        @php($section = \App\Models\UserWebsiteSection::find($sectionId))
        <p><x-dynamic-component :component="$section->icon" class="icon-sm text-{{ $section->color('bg') }}"/> {{ $section->label }}</p>
        <div class="left-sidebar-grid-3">
            @foreach($userWebsites as $w)
                <div class="square">
                    <a href="{{ $w->website->url }}" title="{{ $w->website->label }}" target="_blank"><img src="{{ asset(config('images.icons_websites')).'/'.$w->website->id.'.'.$w->website->icon }}"/></a>
                </div>
            @endforeach
        </div>
    @endforeach
    <p><x-svg.globe class="icon-sm text-orange-400"/> Mes applis</p>
    <div class="left-sidebar-grid-3">
        <div class="square bg-white">
            <a href="http://localhost/00 - API/warframe/laravel8/public/weapons" title="Warframe Codex" target="_blank"><img src="{{ asset(config('images.icons_mes_applis')).'/warframe.png' }}"/></a>
        </div>
        <div class="square bg-white">
            <a href="http://localhost/00-Petits_projets/00-sommaire/utils.php" title="Mes cartes Yu-Gi-Oh" target="_blank"><img src="{{ asset(config('images.icons_mes_applis')).'/yugioh.jpg' }}"/></a>
        </div>
        <div class="square bg-white">
            <a href="http://localhost/00-Petits_projets/0-les_series" title="Renommer ses fichiers" target="_blank"><img src="{{ asset(config('images.icons_mes_applis')).'/les_series.png' }}"/></a>
        </div>
    </div>
</div>