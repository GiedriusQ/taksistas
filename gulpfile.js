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
    mix.phpUnit();
    //mix.sass('app.scss', 'resources/assets/css/libs.css');
    //mix.scripts(['jquery.js', 'bootstrap.js', 'sweetalert.min.js'], 'public/js/libs.js');
    //mix.styles(['libs.css', 'sweetalert.css'], 'public/css/libs.css');
    //mix.styles(['main.css'], 'public/css/main.css');
    //mix.scripts(['main.js'], 'public/js/main.js');
    //mix.copy('resources/assets/fonts', 'public/fonts');
});
