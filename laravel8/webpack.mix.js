const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/my_fetch.js', 'public/js')
    .js('resources/js/clipboard.js', 'public/js')
    .js('resources/js/my_notyf.js', 'public/js')
    .js('resources/js/products.js', 'public/js')
    .js('resources/js/productsSearch.js', 'public/js')
    .js('resources/js/groupBuys.js', 'public/js')
    .js('resources/js/manageFriends.js', 'public/js')
    .js('resources/js/tchat.js', 'public/js')
    .js('resources/js/listings.js', 'public/js')
    .js('resources/js/travelJourneys.js', 'public/js')
    .js('resources/js/templates.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
        require('autoprefixer'),
    ])
    .postCss('resources/css/custom_app.css', 'public/css', [require('tailwindcss')])
    .postCss('resources/css/admin/admin.css', 'public/css/admin', [require('tailwindcss')])
    .postCss('resources/css/admin/design_system.css', 'public/css/admin', [require('tailwindcss')])
    .postCss('resources/css/header.css', 'public/css', [require('tailwindcss')])
    // .postCss('resources/css/my_templates/default.css', 'public/css', [require('tailwindcss')]) // A compléter (pour l'instant en partie header.css)
    // .postCss('resources/css/my_templates/video_game.css', 'public/css', [require('tailwindcss')]) // A compléter (pour l'instant en partie header.css)
    .postCss('resources/css/footer.css', 'public/css', [require('tailwindcss')])
    .postCss('resources/css/sidebar.css', 'public/css', [require('tailwindcss')])
    .postCss('resources/css/pagination.css', 'public/css', [require('tailwindcss')])
    .postCss('resources/css/products_search.css', 'public/css', [require('tailwindcss')])
    .postCss('resources/css/sidebar_friends.css', 'public/css', [require('tailwindcss')])
    .postCss('resources/css/video_games_search.css', 'public/css', [require('tailwindcss')])
    .postCss('resources/css/list_products.css', 'public/css', [require('tailwindcss')])
    .postCss('resources/css/lists.css', 'public/css', [require('tailwindcss')]);

mix.sass('resources/assets/sass/app.scss', 'public/css');

if (mix.inProduction()) {
    mix.version();
}
