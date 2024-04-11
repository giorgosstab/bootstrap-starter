let mix = require('laravel-mix');
require('laravel-mix-webp');
require('laravel-mix-criticalcss');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laraigniter 1 application. By default, we are compiling the Sass
 | file for your application, as well as bundling up your JS files.
 |
 */

mix
    .setPublicPath('public/build')
    .setResourceRoot('/build')
    .options({
        processCssUrls: true,
        terser: {
            extractComments: false,
        }
    })

    // Styles
    .sass('resources/sass/app.scss', 'assets')
    .sass('resources/sass/custom/bootstrap.scss', 'assets/vendor')
    .sass('resources/sass/custom/fonts.scss', 'assets/vendor')

    // Scripts
    .js('resources/js/app.js', 'assets')
    .js('resources/js/custom.js', 'assets')
    .js('resources/js/vendor/bootstrap.js', 'assets/vendor')
    .js('resources/js/vendor/jquery.js', 'assets/vendor')

    // .postCss('resources/css/app.css', 'assets', [
    //
    // ])

    // Copy Directories & Files
    // .copyDirectory('resources/images', 'public/build/images')

    // Generate image to webp
    // .ImageWebp({
    //     disable: !mix.inProduction(),
    //     from: 'resources/images',
    //     to: 'public/build/images',
    // })

    // Critical Stylesheet Files
    // .criticalCss({
    //     enabled: mix.inProduction(),
    //     paths: {
    //         base: process.env.APP_URL,
    //         templates: './public/build/assets/',
    //         suffix: '_critical.min'
    //     },
    //     urls: [
    //         {
    //             url: 'index',
    //             template: 'home'
    //         },
    //     ],
    //     //Now using https://github.com/addyosmani/critical v4.0.1
    //     options: {
    //         //It's important to note here you should NOT set inline:true, this will break the whole system.
    //         width: 411,
    //         height: 823,
    //         penthouse: {
    //             timeout: 1200000
    //         }
    //     },
    // });

mix.sourceMaps(!mix.inProduction());

if (mix.inProduction()) {
    mix.version();
    mix.disableNotifications();
}


