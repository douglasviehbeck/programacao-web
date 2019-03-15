const mix = require('laravel-mix');

mix.webpackConfig({
    resolve: {
        alias: {
            '@mixins': path.resolve(
                __dirname,
                'resources/js/mixins'
            )
        }
    }
});

mix.options({
    hmrOptions: {
        host: 'pweb.local'
    }
});

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css');
