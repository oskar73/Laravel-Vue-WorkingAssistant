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

mix.sass('resources/sass/back.scss', 'public/assets/css/dev1/back.css');
mix.sass('resources/sass/front.scss', 'public/assets/css/dev1/front.css');
mix.sass('resources/sass/both.scss', 'public/assets/css/dev1/both.css');
mix.sass('resources/sass/preview.scss', 'public/assets/css/dev1/preview.css');

mix.js('resources/js/app.js', 'public/assets/js/app.js').version();
mix.sass('resources/sass/app.scss', 'public/assets/css/app.css').version();

//front all css
mix.styles([
    'public/assets/css/app.css',
    'public/assets/vendors/fontawesome/fontawesome.min.css',
    'public/assets/vendors/izitoastr/iziToast.min.css',
    'public/assets/vendors/tipso/tipso.min.css',
    'public/assets/css/dev1/both.css',
    'public/assets/css/dev1/front.css'
], 'public/assets/css/style.css').version();

//backend styles
mix.styles([
    'public/assets/vendors/base/vendors.bundle.css',
    'public/assets/vendors/base/style.bundle.css',
    'public/assets/vendors/datatable/datatables.min.css',
    'public/assets/vendors/izitoastr/iziToast.min.css',
    'public/assets/vendors/tipso/tipso.min.css',
    'public/assets/css/dev1/both.css',
    'public/assets/css/dev1/back.css'
], 'public/assets/css/all.css').version();

//front all js
mix.scripts([
    'public/assets/js/app.js',
    'public/assets/vendors/izitoastr/iziToast.min.js',
    'public/assets/vendors/tipso/tipso.min.js',
    'public/assets/vendors/progressive-image/progressive-image.js',
    'public/assets/js/front.js',
    'public/assets/js/both.js'
], 'public/assets/js/script.js').version();

//backend scripts
mix.scripts([
    'public/assets/vendors/base/vendors.bundle.js',
    'public/assets/vendors/base/scripts.bundle.js',
    'public/assets/vendors/datatable/datatables.min.js',
    'public/assets/vendors/izitoastr/iziToast.min.js',
    'public/assets/vendors/tipso/tipso.min.js',
    'public/assets/vendors/progressive-image/progressive-image.js',
    'public/assets/js/back.js',
    'public/assets/js/both.js'
], 'public/assets/js/all.js').version();




