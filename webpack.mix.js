let mix = require('laravel-mix')
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

// mix.js('resources/assets/js/app.js', 'public/js')
//     .sass('resources/assets/sass/app.scss', 'public/css')

// laravel-mix webpack config
var rm = require('rimraf')
rm(path.join(__dirname, 'public/assets/js/vendor'), err => {
})

mix.webpackConfig({
    resolve: {
        extensions: ['.js', '.vue', '.json'],
        alias: {
            // 'vue$': 'vue/dist/vue.esm.js',
            '@': __dirname + '/resources/assets/js/backend/components',
            'mixins': __dirname + '/resources/assets/js/backend/mixins',
            'config': __dirname + '/resources/assets/js/backend/config'
        },
    },
    output: {
        publicPath: '/',
        // chunkFilename: 'assets/js/vendor/[name].js',
        chunkFilename: 'assets/js/vendor/[name].[chunkhash].js',
    }
})

// mix.js('resources/assets/js/backend/pages/*.js', 'public/assets/js');
mix.js('resources/assets/js/backend/App.js', 'public/assets/js')
