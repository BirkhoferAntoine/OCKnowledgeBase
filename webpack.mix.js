const mix = require('laravel-mix');
const path = require('path');
require('laravel-mix-twig-to-html');
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

/*mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');*/


mix.options({
    postCss: [
        require('autoprefixer'),
    ],
});
mix.setPublicPath('public');

mix.webpackConfig({
    resolve: {
        extensions: ['.js', '.vue'],
        alias: {
            '@': __dirname + 'resources'
        }
    },
    output: {
        chunkFilename: 'js/chunks/[name].js',
    },
});

// used to run app using reactjs
mix.react('src/index.js', 'public/js/app.js').version();


mix.twigToHtml({
    files: 'resources/views/templates/web.twig',
    fileBase: 'resources/views/templates/',
});