const mix = require('laravel-mix');

mix.setPublicPath('public');

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
        host: 'pweb.local',
        port: 8079,
    }
});

mix.js('resources/js/app.js', 'public/js/app.js')
   .sass('resources/sass/app.scss', 'public/css/app.css');
