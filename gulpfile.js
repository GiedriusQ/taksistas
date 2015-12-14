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

elixir(function (mix) {
    mix.sass('app.scss', 'public/css/libs.css');
    mix.scripts(['bootstrap.js', 'jquery.js'], 'public/js/libs.js');
    mix.styles(['main.css'], 'public/css/main.css');
    mix.scripts(['main.js'], 'public/js/main.js');
    mix.copy('resources/assets/fonts', 'public/fonts');
});
