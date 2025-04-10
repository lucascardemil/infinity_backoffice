const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/landing/app.js', 'public/js/landing.js')
    .js('resources/js/admin/app.js', 'public/js/admin.js')
    .vue()
    .sass('resources/sass/admin/app.scss', 'public/css/admin.css')
    .sass('resources/sass/landing/app.scss', 'public/css/landing.css');
