@extends('template')

@section('breadcrumbs')
    {{ Breadcrumbs::render('sitemap') }}
@endsection

@section('content')
    <h1>{{ __('Sitemap') }}</h1>
    <hr class="mb-4"/>
    <div class="grid grid-cols-4 gap-8">
        <div class="flex flex-col gap-4">
            <h2>{{ __('The website') }}</h2>
            <hr />
            <x-Sitemap.Link label="Home" url="{{ route('products.index') }}"/>
            <x-Sitemap.Link label="My products" url="{{ route('myProducts') }}" ml="4"/>
            <x-Sitemap.Link label="Add a product" url="{{ route('products.create') }}" ml="4"/>
            <x-Sitemap.Link label="Contact-me" url="https://www.linkedin.com/in/thomas-chazelles-30491a8b/" target="_blank" ml="4"/>
            <x-Sitemap.Link label="Sitemap" url="{{ route('sitemap') }}" ml="4"/>
        </div>
        <div class="flex flex-col gap-4">
            <h2>{{ __('Your account') }}</h2>
            <hr />
            <x-Sitemap.Link label="My profile" url="{{ route('profile.show') }}"/>
            <x-Sitemap.Link label="My lists" url="{{ route('lists.index') }}" ml="4"/>
            <x-Sitemap.Link label="My friends" url="{{ route('myFriends') }}" ml="4"/>
            <x-Sitemap.Link label="Login" url="{{ route('login') }}"/>
            <x-Sitemap.Link label="Logout" url="{{ route('logout') }}"/>
        </div>
        <div class="flex flex-col gap-4">
            <h2>{{ __('My historic') }}</h2>
            <hr />
            <x-Sitemap.Link label="My purchases" url="{{ route('userHistoric', 'purchases') }}"/>
            <x-Sitemap.Link label="My sells" url="{{ route('userHistoric', 'sellings') }}"/>
            <x-Sitemap.Link label="My benefits" url="{{ route('userBenefits') }}"/>
        </div>
        <div class="flex flex-col gap-4">
            <h2>{{ __('Database') }}</h2>
            <hr />
            <x-Sitemap.Link label="Dashboard" url="{{ route('websites.index') }}"/>
            <x-Sitemap.Link label="Websites list" url="{{ route('websites.index') }}" ml="4"/>
            <x-Sitemap.Link label="Add a website" url="{{ route('websites.create') }}" ml="8"/>
            <x-Sitemap.Link label="Product's states list" url="{{ route('states.products.index') }}" ml="4"/>
            <x-Sitemap.Link label="Add a product's state" url="{{ route('states.products.create') }}" ml="8"/>
            <x-Sitemap.Link label="Selling's states list" url="{{ route('states.sells.index') }}" ml="4"/>
            <x-Sitemap.Link label="Add a selling's state" url="{{ route('states.sells.create') }}" ml="8"/>
        </div>
    </div>
    <h1 class="text-red-400">{{ __('Video Games Section') }}</h1>
    <hr class="mb-4"/>
    <div class="grid grid-cols-4 gap-8">
        <div class="flex flex-col gap-4">
            <h2>{{ __('The website') }}</h2>
            <hr />
            <x-Sitemap.Link label="Home" url="{{ route('products.index') }}"/>
            <x-Sitemap.Link label="Video games list" url="{{ route('video_games.index') }}" ml="4"/>
        </div>
        <div class="flex flex-col gap-4">
            <h2>{{ __('Database') }}</h2>
            <hr />
            <x-Sitemap.Link label="Dashboard" url="{{ route('websites.index') }}"/>
            <x-Sitemap.Link label="Supports list" url="{{ route('vg_supports.index') }}" ml="4"/>
            <x-Sitemap.Link label="Add a support" url="{{ route('vg_supports.create') }}" ml="8"/>
        </div>
    </div>
@endsection