const mix = require('laravel-mix');

mix.js(['resources/js/app.js','resources/js/user.js'],'public/js/app.js')
    .css('resources/css/app.css', 'public/css/app.css');


