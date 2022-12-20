<div class="left">
    <!-- Transformer en composant -->
    @if($menu === 'database')
        <a href="#" class="active">
    @else
        <a href="{{ route('websites.index') }}">
    @endif
        <x-svg.big.db class="icon"/>
        {{ __('Database') }}
    </a>
    <div class="w-full">
        @if($menu === 'database')
            <a href="{{ route('websites.index') }}" class="sub {{ $sub === 'websites' ? 'active' : '' }}">{{ __('Websites') }}</a>
            <a href="{{ route('tags.index') }}" class="sub {{ $sub === 'tags' ? 'active' : '' }}">{{ __('Tags') }}</a>
            <a href="{{ route('states.products.index') }}" class="sub {{ $sub === 'product_states' ? 'active' : '' }}">{{ __("Products' states") }}</a>
            <a href="{{ route('states.sells.index') }}" class="sub {{ $sub === 'sell_states' ? 'active' : '' }}">{{ __("Sellings' states") }}</a>
            <a href="{{ route('vg_supports.index') }}" class="sub {{ $sub === 'vg_supports' ? 'active' : '' }}">{{ __("Supports list") }}</a>
            <a href="{{ route('vg_developers.index') }}" class="sub {{ $sub === 'vg_developers' ? 'active' : '' }}">{{ __("Developers list") }}</a>
        @endif
    </div>
    <a href="{{ route('profile.show') }}" class="{{ $menu === 'profil' ? 'active' : '' }}">
        <x-svg.big.user class="icon"/>
        {{ __('Profile') }}
    </a>
    @if($menu === 'profil')
        <a href="{{ route('profile.show') }}" class="sub {{ $sub === 'user' ? 'active' : '' }}"">{{ __('My account') }}</a>
        <a href="#" class="sub {{ $sub === 'website' ? 'active' : '' }}"">{{ __('The website') }}</a>
    @endif
    <a href="#" class="{{ $menu === 'messages' ? 'active' : '' }}">
        <x-svg.big.msg class="icon"/>
        {{ __('Messages') }}
    </a>
    <a href="#" class="{{ $menu === 'stats' ? 'active' : '' }}">
        <x-svg.big.stats class="icon"/>
        {{ __('Statistics') }}
    </a>
    <a href="{{ route('design_system') }}"  class="{{ $menu === 'design' ? 'active' : '' }}">
        <x-svg.big.screen class="icon"/>
        {{ __('Design') }}
    </a>
    @if($menu === 'stats')
        <a href="#" class="sub">{{ __('Global') }}</a>
        <a href="#" class="sub">{{ __('Purchases') }}</a>
        <a href="#" class="sub">{{ __('Sellings') }}</a>
    @endif
    <div class="h-80 w-full"></div>
</div>