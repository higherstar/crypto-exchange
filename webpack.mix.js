const { mix } = require('laravel-mix');

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

mix.js('resources/assets/js/app.js', 'public/js')
    .scripts('resources/assets/js/homepage.js', 'public/js/homepage.js')
    .scripts('resources/assets/js/bootstrap-filestyle.js', 'public/js/bootstrap-filestyle.js')
    .scripts('resources/assets/js/icheck.min.js', 'public/js/icheck.min.js')
    .sass('resources/assets/scss/app.scss', 'public/css')
    .styles([
        'resources/assets/css/coming_soon/soonx.css',
        'resources/assets/css/coming_soon/media.css',
    ], 'public/css/coming_soon.css')
    .scripts('resources/assets/js/coming_soon/jquery.js', 'public/js/coming_soon/jquery.js')
    .scripts('resources/assets/js/coming_soon/jparticle.jquery.js', 'public/js/coming_soon/jparticle.jquery.js')
    // .scripts('resources/assets/js/coming_soon/functions.js','public/js/coming_soon/functions.js')
    .scripts('resources/assets/js/coming_soon/jquery.downCount.js','public/js/coming_soon/jquery.downCount.js');

