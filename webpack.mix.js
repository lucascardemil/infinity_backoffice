const mix = require('laravel-mix');

mix.js('resources/js/landing/app.js', 'public/js/landing.js')
    .js('resources/js/admin/app.js', 'public/js/admin.js')
    .vue({ version: 2 })  // 👈 Esto es clave
    .sass('resources/sass/admin/app.scss', 'public/css/admin.css')
    .sass('resources/sass/landing/app.scss', 'public/css/landing.css');
