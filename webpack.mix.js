const mix = require('laravel-mix');
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');
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

module.exports = {
    //...
    optimization: {
        minimize: true,
        minimizer: [new UglifyJsPlugin({
            parallel: 4,
            uglifyOptions: {
                warnings: false,
                parse: {},
                compress: {},
                mangle: true, // Note `mangle.properties` is `false` by default.
                output: null,
                toplevel: false,
                nameCache: null,
                ie8: false,
                keep_fnames: false,
            }
        })]
    }
};

// mix.webpackConfig({
//     externals: {
//         jquery: 'jQuery'
//     }
// });

mix.js([
      //  'resources/js/jquery.min.js',
        'resources/js/app.js'
    ]
    , 'public/js/app.js');
//.version();

//.sass('resources/sass/app.scss', 'public/css');
