const mix = require('laravel-mix');

mix.js('assets/js/app.js', 'assets/js')
    .vue()
    .css('assets/css/styles.css', 'assets/css')
    .setPublicPath('assets')
    .version(); // Для кэш-бастинга
