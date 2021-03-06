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
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
        require('autoprefixer'),
    ])
    .postCss('resources/css/custom_app.css', 'public/css', [require('tailwindcss')])
    .postCss('resources/css/admin.css', 'public/css', [require('tailwindcss')])
    .postCss('resources/css/header.css', 'public/css', [require('tailwindcss')])
    .postCss('resources/css/footer.css', 'public/css', [require('tailwindcss')])
    .postCss('resources/css/pagination.css', 'public/css', [require('tailwindcss')])
    .postCss('resources/css/products_search.css', 'public/css', [require('tailwindcss')])
    .postCss('resources/css/list_products.css', 'public/css', [require('tailwindcss')]);

mix.sass('resources/assets/sass/app.scss', 'public/css');

if (mix.inProduction()) {
    mix.version();
}
