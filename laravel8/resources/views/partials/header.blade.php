@php($path = Request::path())
<nav class="flex items-center justify-between flex-wrap fixed w-full z-20 bg-gray-800 py-2 lg:px-12 shadow-xl">
    <div class="flex items-center sm:static sm:inset-auto sm:ml-6 sm:pr-0">
        <x-svg.big.menu id="icon-sidebar"/>
    </div>

    <div class="flex justify-between w-full pl-6 pr-2 border-solid border-b-2 border-gray-300 pb-2 lg:w-auto lg:border-b-0 lg:pb-0">
        <div class="flex items-center flex-shrink-0 text-white mr-16">
            <a href="{{ route('products.index') }}" class="text-white"><span class="font-semibold text-xl tracking-tight">Wish List</span></a>
        </div>
    </div>

    <div class="menu w-full block flex-grow flex px-8 pt-3 lg:items-center lg:w-auto lg:px-3 lg:pt-0">
        <div class="flex text-md font-bold text-blue-700 flex-grow">
            <a href="{{ route('products.index') }}" class="inline-flex navitem {{ $path === 'products' ? 'active' : 'not-active' }}">
                <x-svg.house class="icon-xs"/>
                <span class="px-1">{{ __('Home') }}</span>
            </a>
            <x-menu.submenu id="my_datas" href="{{ route('my_products') }}" active="{{ $path === 'products/user' }}">{{ __('My products') }}</x-menu.submenu>
            <x-menu.submenu id="create" href="{{ route('products.create') }}" active="{{ $path === 'products/create' }}">{{ __('Add new') }}</x-menu.submenu>
            <x-menu.link href="{{ route('sitemap') }}" active="{{ $path === 'sitemap' }}">{{ __('Sitemap') }}</x-menu.link>
            <x-menu.ext_link href="https://www.boursorama.com/bourse/devises/convertisseur-devises/dollar-euro">{{ __('Convertisseur $ -> €') }}</x-menu.ext_link>

            <x-menu.submenu id="externals">{{ __('External links') }}</x-menu.submenu>
            <x-menu.ext_link href="http://localhost/phpmyadmin/db_structure.php?server=2&db=api_products_managing">
                <x-svg.big.db class="inline-flex icon-sm mr-1"/>Base de données
            </x-menu.ext_link>
        </div>
        <!-- Fast menu search -->
        <form id="fast_search" action="{{ route('products.index') }}" method="POST">
            @method("GET")
            <div class="relative flex inline-flex justify-end" onMouseOver="open_search();" onMouseOut="open_search(false);">
                <input id="fast_search_text" class="{{ isset($search)? 'focus_search' : '' }}" type="search" name="search" placeholder="{{ __('Search products...') }}" value="{{ isset($search)? $search : '' }}" onFocus="open_search();" onFocusOut="open_search(false);">
                <!-- <x-svg.big.circle_search onClick="document.forms['fast_search'].submit();"/> -->
                <x-svg.big.circle_search onClick="document.forms['fast_search'].submit();"/>
            </div>
        </form>
        <!-- menu icons -->
        <div class="flex items-center gap-5 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
            <x-svg.big.bell id="icon-bell" notif="{{ auth()->user()->unreadNotifications->count() }}"/>
            <x-svg.big.msg id="icon-msg"/>
            <x-svg.big.profil id="icon-profil"/>
            <!--
            <svg class="icon-sm text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <svg class="icon-sm text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
            </svg>
            <svg class="icon-sm text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
            </svg> -->
        </div>
    </div>
</nav>

<div id="left_sidebar">
    <div class="icons">
        <x-svg.big.globe_alt id="icon-globe_alt"/>
        <x-svg.big.globe id="icon-globe"/>
    </div>
    
    <div id="left_sidebar_websites">
        <div>
            Test de contenu
        </div>
        <div>
            Liste des sites
        </div>
        <div>
            Mon chrono
        </div>
    </div>
</div>

<nav id="submenu">
    <div id="submenu_my_datas" class="submenu" onMouseOver="submenu(true, 'my_datas');" onMouseOut="submenu(false, 'my_datas');">
        <a href="{{ route('my_products') }}">{{ __('My products') }}</a>
        <a href="{{ route('lists.index') }}">{{ __("My lists") }}</a>
        <a href="{{ route('user_historic', 'purchases') }}">{{ __('My purchases') }}</a>
        <a href="{{ route('user_historic', 'sellings') }}">{{ __('My sells') }}</a>
    </div>
    <div id="submenu_create" class="submenu" onMouseOver="submenu(true, 'create');" onMouseOut="submenu(false, 'create');">
        <a href="{{ route('products.create') }}">{{ __('Product') }}</a>
        <a href="{{ route('group_buys.create') }}">{{ __('Group purchase') }}</a>
        <a href="{{ route('lists.create') }}">{{ __('Products list') }}</a>
        <hr class="py-1 border-black"/>
        <a href="{{ route('websites.create') }}">{{ __('Website') }}</a>
        <a href="{{ route('states.products.create') }}">{{ __("Product's state") }}</a>
        <a href="{{ route('states.sells.create') }}">{{ __("Selling's state") }}</a>
    </div>
    <div id="submenu_externals" class="submenu" onMouseOver="submenu(true, 'externals');" onMouseOut="submenu(false, 'externals');">
        <a href="https://www.prixdestimbres.fr/tarifs-colis.html">{{ __('Tarifs Colissimo') }}</a>
        <a href="https://www.laposte.fr/courriers-colis/conseils-pratiques/les-emballages-a-affranchir">{{ __('Emballages de la Poste') }}</a>
    </div>
    <div id="subicon_bell" class="subicon flex justify-end gap-1">
        @if(auth()->user()->unreadNotifications->isEmpty())
            <span class="px-2">Aucune notification</span>
        @else
            @foreach(auth()->user()->unreadNotifications as $notif)
                <a href="{{ route('products.showFromNotification', ['product' => $notif->data['product_id'], 'notification' => $notif->id]) }}" class="flex items-center mx-1 bg-white" title="{{ $notif->data['product_label'] }}">
                    <img class="w-2/6 h-20" src="{{ asset(config('images.path_products').'/'.$notif->data['product_id'].'/'.$notif->data['product_photo']) }}"/>
                    <span class="w-4/6 flex justify-center text-black text-sm">{{ !strcmp($notif->type, 'App\Notifications\ProductSoonExpire')? __('Expire') : __('Disponible') }} dans {{ $notif->data['days'] }} jour(s)</span>
                </a>
            @endforeach
        @endif
    </div>
    <div id="subicon_user" class="subicon menu">
        <span>
            <x-svg.cog class="icon-xs"/>
            <a class="no-propagate" href="{{ route('profile.show') }}">{{ __('My profile') }}</a>
        </span>
        <span>
            <x-svg.log_out class="icon-xs"/>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">{{ __('Logout') }}</button>
            </form>
        </span>
    </div>
</nav>