<footer id="footer">
    <div class="nav md:w-full">
        <div>
            <span>{{ __('Products') }}</span>
            <ul>
                <li><a href="{{ route('products.create') }}">{{ __('Add new') }}</a></li>
                <li><a href="{{ route('my_products', ['stock' => 'product_available']) }}">{{ __('Availables') }}</a></li>
                <li><a href="{{ route('my_products', ['stock' => 'product_to_come']) }}">{{ __('Soon') }}</a></li>
                <li><a href="{{ route('my_products', ['stock' => 'product_expired']) }}">{{ __('No offer') }}</a></li>
            </ul>
        </div>
        <div>
            <span>{{ __('Video Games') }}</span>
            <ul>
                <li><a href="#">{{ __('List') }}</a></li>
                <li><a href="{{ route('vg_supports.index') }}">{{ __('Supports list') }}</a></li>
                <li><a href="{{ route('vg_developers.index') }}">{{ __('Developers list') }}</a></li>
            </ul>
        </div>
        <div>
            <span>{{ __('Dashboard') }}</span>
            <ul>
                <li><a href="{{ route('websites.index') }}">{{ __('Websites') }}</a></li>
                <li><a href="{{ route('tags.index') }}">{{ __('Tags') }}</a></li>
                <li><a href="{{ route('states.products.index') }}">{{ __("Products' states") }}</a></li>
                <li><a href="{{ route('states.sells.index') }}">{{ __("Sellings' states") }}</a></li>
            </ul>
        </div>
        <div>
            <span>{{ __('My datas') }}</span>
            <ul>
                <li><a href="{{ route('my_products') }}">{{ __('My products') }}</a></li>
                <li><a href="{{ route('lists.index') }}">{{ __('My lists') }}</a></li>
                <li><a href="{{ route('user_historic', 'purchases') }}">{{ __("My purchases") }}</a></li>
                <li><a href="{{ route('user_historic', 'sellings') }}">{{ __("My sells") }}</a></li>
            </ul>
        </div>
        <div>
            <span>{{ __('The website') }}</span>
            <ul>
                <li><a href="{{ route('products.index') }}">{{ __('Home') }}</a></li>
                <li><a href="https://www.linkedin.com/in/thomas-chazelles-30491a8b/" target="_blank">{{ __('Contact-me') }}</a></li>
                <li><a href="{{ route('sitemap') }}">{{ __('Sitemap') }}</a></li>
            </ul>
        </div>
    </div>
    <div class="copyright">Copyright <img class="icon-xs inline-flex" src="{{ asset('copyright.png') }}"/> Keiysuke21. {{ __('All rights reserved.') }}</div>
</footer>