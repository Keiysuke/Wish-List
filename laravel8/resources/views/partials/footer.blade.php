<footer id="footer">
    <div class="nav md:w-full">
        <div>
            <span>{{ __('Products') }}</span>
            <ul>
                <li><a href="{{ route('products.create') }}">{{ __('Add new') }}</a></li>
                <li><a href="{{ route('myProducts', ['stock' => 'product_available']) }}">{{ __('Availables') }}</a></li>
                <li><a href="{{ route('myProducts', ['stock' => 'product_to_come']) }}">{{ __('Soon') }}</a></li>
                <li><a href="{{ route('myProducts', ['stock' => 'product_expired']) }}">{{ __('No offer') }}</a></li>
            </ul>
        </div>
        <div>
            <span>{{ __('Crowdfunding') }}</span>
            <ul>
                <li><a href="{{ route('crowdfundings.create') }}">{{ __('Add new') }}</a></li>
                <li><a href="{{ route('myProducts', ['crowdfunding' => 1]) }}">{{ __('Liste') }}</a></li>
            </ul>
        </div>
        <div>
            <span>{{ __('Video Games') }}</span>
            <ul>
                <li><a href="{{ route('video_games.create') }}">{{ __('Add new') }}</a></li>
                <li><a href="{{ route('video_games.index') }}">{{ __('List') }}</a></li>
                <li><a href="{{ route('vg_supports.index') }}">{{ __('Supports list') }}</a></li>
                <li><a href="{{ route('vg_developers.index') }}">{{ __('Developers list') }}</a></li>
            </ul>
        </div>
        <div>
            <span>{{ __('Book Publishers') }}</span>
            <ul>
                <li><a href="{{ route('book_publishers.index') }}">{{ __('Book Publishers list') }}</a></li>
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
                <li><a href="{{ route('myProducts') }}">{{ __('My products') }}</a></li>
                <li><a href="{{ route('lists.index') }}">{{ __('My lists') }}</a></li>
                <li><a href="{{ route('userHistoric', 'purchases') }}">{{ __("My purchases") }}</a></li>
                <li><a href="{{ route('userHistoric', 'sellings') }}">{{ __("My sells") }}</a></li>
                <li><a href="{{ route('userBenefits') }}">{{ __("My benefits") }}</a></li>
            </ul>
        </div>
        <div>
            <span>{{ __('The website') }}</span>
            <ul>
                <li><a href="{{ route('products.index') }}">{{ __('Home') }}</a></li>
                <li><a href="https://www.linkedin.com/in/thomas-chazelles-30491a8b/" target="_blank">{{ __('Contact-me') }}</a></li>
                <li><a href="{{ route('designSystem') }}">{{ __('Design') }}</a></li>
                <li><a href="{{ route('sitemap') }}">{{ __('Sitemap') }}</a></li>
            </ul>
        </div>
    </div>
    <div class="copyright">Copyright <img class="icon-xs inline-flex" src="{{ asset('copyright.png') }}"/> <i>Créé par Keiysuke21 avec <a class="link" href="https://tailwindcss.com/" target="_blank">Tailwind</a> & <a class="link" href="https://laravel.com/" target="_blank">Laravel</a></i>. {{ __('All rights reserved.') }}</div>
</footer>