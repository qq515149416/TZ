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

mix.js('resources/assets/js/app.js', 'public/js');
   // .sass('resources/assets/sass/app.scss', 'public/css');
mix.less('resources/assets/less/index.less', 'public/css')
   .js('resources/assets/js/script.js', 'public/js')
   .js('resources/assets/js/wap/main.js', 'public/js/wap')
   .less('resources/assets/less/common.less', 'public/css')
   .less('resources/assets/less/layout/index.less', 'public/css/layout')
   .less('resources/assets/less/wap/main.less', 'public/css/wap')
   .js('resources/user_assets/js/main.js', 'public/user_assets/js')
   .less('resources/user_assets/less/main.less', 'public/user_assets/css')
   .copyDirectory('resources/user_assets/images', 'public/user_assets/images')
   .copyDirectory('resources/assets/images/laborDay', 'public/images/laborDay');

// mix.js('resources/user_assets/js/main.js', 'public/user_assets/js')
//    .less('resources/user_assets/less/main.less', 'public/user_assets/css')
//    .options({
//         processCssUrls: false
//    })
//    .copyDirectory('resources/user_assets/images', 'public/user_assets/images');
