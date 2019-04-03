let mix = require('laravel-mix');

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
   .sass('resources/assets/sass/app.scss', 'public/css');
mix.less('resources/assets/less/index.less', 'public/css')
   .js('resources/assets/js/script.js', 'public/js')
   .less('resources/assets/less/common.less', 'public/css')
   .less('resources/assets/less/layout/index.less', 'public/css/layout');
