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
    .sass('resources/sass/fontawesome.scss', 'public/css')
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss')('./tailwind.config.js'),
    ])
    .webpackConfig(require('./webpack.config'))
    .js('resources/js/perch.js', 'public/js')
    .js('resources/js/fly.js', 'public/js')
    .js('resources/js/home.js', 'public/js')
    .js('resources/js/interface.js', 'public/js')
    .js('resources/js/path.js', 'public/js')
    .js('resources/js/wave.js', 'public/js').options({
        processCssUrls: true,
    });
