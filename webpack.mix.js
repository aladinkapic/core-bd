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

mix.
    js([
        'resources/js/app.js',
        'resources/js/steps.js',
        'resources/js/customJs/notify.js'
    ], 'public/js')
    .scripts([

        'resources/js/notifications.js',
        'resources/js/hr/sluzbenici/dodaj_sluzbenika.js',
        'resources/js/hr/sluzbenici/dodatne_funkcije.js',
        'resources/js/all_functions.js',
        'resources/js/hr/odsustva/calendar.js',
        'resources/js/customJs/datepicker.js',
        'resources/js/hr/uprava/uprava.js',
        'resources/js/ekonkurs/ekonkurs.js',
        'resources/js/ostalo/unutrasnja_org.js',
        'resources/js/ostalo/obuke.js',
        'resources/js/ostalo/uloge.js',
        'resources/js/ostalo/obavijesti.js'
    ], 'public/js/sluzbenik.js')



    .js([
        'resources/js/hr/organizacija/organizacija.js',
        'resources/js/hr/organizacija/orgchart.js'
    ], 'public/js/organizacija.js')

    .js([
        'resources/js/datepicker.js'
    ], 'public/js/datepicker.js')



.styles([
    'resources/css/main.css',
    'resources/css/style.css',
    'resources/css/notifications.css',
    'resources/css/hr/sluzbenici/sluzbenici.css',
    'resources/css/customBootstrap.css',
    'resources/css/test.css',
    'resources/css/organizacija.css',
    'resources/css/hr/odsustva/calendar.css',
    'resources/css/ekonkurs/ekonkurs.css',
    'resources/css/jquery-ui.min.css',
    'resources/css/ostalo/unutrasnja_org.css'
], 'public/css/all.css')

.styles([
    'resources/css/prijava.css',
], 'public/css/login.css')


.sass('resources/css/emails/email.scss', 'public/css/emails/email.css')
.sass('resources/sass/app.scss', 'public/css')
.sass('resources/sass/fbih/steps.scss', 'public/fbih/steps.css')
.sass('resources/sass/error.scss', 'public/css/errors.css')
.sass('resources/sass/ispis-sluzbenika.scss', 'public/css/ispis-sluzbenika.css');
