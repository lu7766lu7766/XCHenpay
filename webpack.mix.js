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

// laravel-mix webpack config

mix.webpackConfig({
    resolve: {
        extensions: ['.js', '.vue', '.json'],
        alias: {
            // 'vue$': 'vue/dist/vue.esm.js',
            '@': __dirname + '/resources/assets/js/backend/components',
            'mixins': __dirname + '/resources/assets/js/backend/mixins'
        },
    },
})

mix.js('resources/assets/js/backend/report.js', 'public/assets/js');
mix.js('resources/assets/js/backend/OrderSearch.js', 'public/assets/js');
mix.js('resources/assets/js/backend/reportStat.js', 'public/assets/js');
mix.js('resources/assets/js/backend/ApplyNotice.js', 'public/assets/js');
