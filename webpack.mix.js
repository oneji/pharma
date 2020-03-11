const mix = require('laravel-mix');

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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');

// Scripts
mix.copy('resources/assets/js/vendors.min.js', 'public/assets/js/vendors.min.js');
mix.copy('resources/assets/js/plugins.min.js', 'public/assets/js/plugins.min.js');
mix.copy('resources/assets/js/search.min.js', 'public/assets/js/search.min.js');
mix.copy('resources/assets/js/custom/custom-script.min.js', 'public/assets/js/custom/custom-script.min.js');

// Styles
mix.copy('resources/assets/vendors/vendors.min.css', 'public/assets/vendors/vendors.min.css');
mix.copy('resources/assets/css/themes/vertical-modern-menu-template/materialize.min.css', 'public/assets/css/themes/vertical-modern-menu-template/materialize.min.css');
mix.copy('resources/assets/css/themes/vertical-modern-menu-template/style.min.css', 'public/assets/css/themes/vertical-modern-menu-template/style.min.css');
mix.copy('resources/assets/css/pages/login.css', 'public/assets/css/pages/login.css');
mix.copy('resources/assets/css/custom/custom.css', 'public/assets/css/custom/custom.css');

// Images
mix.copy('resources/assets/images', 'public/assets/images');

// Other
mix.copy('resources/assets/vendors', 'public/assets/vendors');

// Fonts
mix.copy('resources/assets/fonts', 'public/assets/fonts');

