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
            <x-sitemap.link label="Home" url="{{ route('products.index') }}"/>
            <x-sitemap.link label="My products" url="{{ route('my_products') }}" ml="4"/>
            <x-sitemap.link label="Add a product" url="{{ route('products.create') }}" ml="4"/>
            <x-sitemap.link label="Contact-me" url="https://www.linkedin.com/in/thomas-chazelles-30491a8b/" target="_blank" ml="4"/>
            <x-sitemap.link label="Sitemap" url="{{ route('sitemap') }}" ml="4"/>
        </div>
        <div class="flex flex-col gap-4">
            <h2>{{ __('Your account') }}</h2>
            <hr />
            <x-sitemap.link label="My profile" url="{{ route('profile.show') }}"/>
            <x-sitemap.link label="Login" url="{{ route('login') }}" ml="4"/>
            <x-sitemap.link label="Logout" url="{{ route('logout') }}" ml="4"/>
        </div>
        <div class="flex flex-col gap-4">
            <h2>{{ __('Database') }}</h2>
            <hr />
            <x-sitemap.link label="Dashboard" url="{{ route('websites.index') }}"/>
            <x-sitemap.link label="Websites list" url="{{ route('websites.index') }}" ml="4"/>
            <x-sitemap.link label="Add a website" url="{{ route('websites.create') }}" ml="8"/>
            <x-sitemap.link label="Product's states list" url="{{ route('states.products.index') }}" ml="4"/>
            <x-sitemap.link label="Add a product's state" url="{{ route('states.products.create') }}" ml="8"/>
            <x-sitemap.link label="Selling's states list" url="{{ route('states.sells.index') }}" ml="4"/>
            <x-sitemap.link label="Add a selling's state" url="{{ route('states.sells.create') }}" ml="8"/>
        </div>
    </div>
@endsection