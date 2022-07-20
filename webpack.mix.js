const mix = require('laravel-mix');
const path = require('path');

if (process.env.npm_lifecycle_event !== 'hot') {
    mix.version()
}

mix.options({
    hmrOptions: {
        host: "localhost",
        port: 8080,
    },
});

// fix css files 404 issue
mix.webpackConfig({
    devServer: {
        allowedHosts: 'all',
        host: '0.0.0.0',
        port: 8080,
    },
});




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
// mix.webpackConfig({
//         resolve: {
//             alias: {
//                 '@': path.resolve('resources/js'),
//             },
//         },
//         devServer: {
//             host: '0.0.0.0',
//             port: 8080,
//         },
// });

mix.js('resources/js/app.js', 'public/js').vue()
    // .postCss('resources/css/app.css', 'public/css', [
    //     //
    // ])
    .sass('resources/scss/app.scss', 'public/css');
mix.browserSync({
    proxy: 'http://localhost',
});

