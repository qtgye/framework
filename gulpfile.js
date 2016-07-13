var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {

    mix
    // .sass([
    // 	'admin/admin.scss'
    // ], 'public/css/admin')
    .sass([
    	'public/app.scss'
    ], 'public/css/public/')
    // .scripts([
    // 	'admin/admin.js',
    // ],'public/js/admin')
    .scripts([
        'public/app.js',
        'public/modules/module.js'
    ],'public/js/public');

});