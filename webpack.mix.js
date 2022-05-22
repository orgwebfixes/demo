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

mix.copy('resources/themes/limitless/assets/swf', 'public/themes/limitless/swf')
    .copy('resources/themes/limitless/assets/css/extras', 'public/themes/limitless/css/extras')
    .copy('resources/themes/limitless/assets/css/icons', 'public/themes/limitless/css/icons')
    .copy('resources/themes/limitless/assets/images', 'public/themes/limitless/images')
    .copy('resources/themes/limitless/assets/images', 'public/themes/limitless/images')
    .copy('resources/themes/limitless/assets/js/fullcalendar', 'public/themes/limitless/js/fullcalendar')
    .copy('resources/themes/limitless/assets/js/plugins/pickers/color', 'public/themes/limitless/plugins/pickers/color')
    .copy('resources/themes/limitless/assets/js/plugins/editors/summernote', 'public/themes/limitless/plugins/editors/summernote')
    .copy('resources/themes/limitless/assets/js/print', 'public/themes/limitless/js/print');

mix.styles([
        'resources/themes/limitless/assets/css/bootstrap.css',
        'resources/themes/limitless/assets/css/colors.css',
        'resources/themes/limitless/assets/css/components.css',
        'resources/themes/limitless/assets/css/core.css',
        'resources/themes/limitless/assets/css/jquery.datetimepicker.css',
        'resources/themes/limitless/assets/css/icons/icomoon/styles.css',
        'resources/themes/limitless/assets/css/icons/fontawesome/styles.min.css',
        'resources/themes/limitless/assets/css/datatables.bootstrap.css',
        'resources/themes/limitless/assets/css/gantt.style.css',
        'resources/themes/limitless/assets/css/custom.css',
    ], 'public/themes/limitless/css/all.css')
    .copy('resources/assets/css/timepicker.min.css', 'public/themes/limitless/css')
    .copy('resources/themes/limitless/assets/css/bootstrap.min.css', 'public/themes/limitless/css')
    .copy('resources/themes/limitless/assets/css/bootstrap-toggle.css', 'public/themes/limitless/css')
    .copy('resources/themes/limitless/assets/css/buttons.dataTables.min.css', 'public/themes/limitless/css')
    .copy('resources/themes/limitless/assets/css/custom.css', 'public/themes/limitless/css')
    .copy('resources/assets/css/fontawesome-5.3.1.css', 'public/dist')
    .copy('resources/assets/css/fonts-google-montserrat.css', 'public/dist');

    mix.scripts([
        'resources/themes/limitless/assets/js/core/libraries/jquery.min.js',
        'resources/themes/limitless/assets/js/plugins/forms/selects/select2.min.js',
        'resources/themes/limitless/assets/js/jquery.datetimepicker.js',
        'resources/themes/limitless/assets/js/plugins/tables/datatables/datatables.min.js',
        'resources/themes/limitless/assets/js/plugins/media/fancybox.min.js',
        'resources/themes/limitless/assets/js/jquery.ui.widget.js',
        'resources/themes/limitless/assets/js/jquery.iframe-transport.js',
        'resources/themes/limitless/assets/js/jquery.fileupload.js',
        'resources/themes/limitless/assets/js/pnotify.js',
        'resources/themes/limitless/assets/js/custom.js',
        'resources/themes/limitless/assets/js/bootbox.min.js',
        'resources/themes/limitless/assets/js/plugins/loaders/pace.min.js',
        'resources/themes/limitless/assets/js/core/libraries/bootstrap.min.js',
        'resources/themes/limitless/assets/js/plugins/loaders/blockui.min.js',
        'resources/themes/limitless/assets/js/plugins/forms/styling/uniform.min.js',
        'resources/themes/limitless/assets/js/plugins/visualization/d3/d3.min.js',
        'resources/themes/limitless/assets/js/plugins/visualization/d3/d3_tooltip.js',
        'resources/themes/limitless/assets/js/plugins/forms/styling/switchery.min.js',
        'resources/themes/limitless/assets/js/plugins/forms/selects/bootstrap_multiselect.js',
        'resources/themes/limitless/assets/js/plugins/ui/moment/moment.min.js',
        'resources/themes/limitless/assets/js/core/libraries/jasny_bootstrap.min.js',
        'resources/themes/limitless/assets/js/core/app.js',
        'resources/themes/limitless/assets/js/pages/login.js',
        'resources/themes/limitless/assets/js/locker.js',
        'resources/themes/limitless/assets/js/jquery-ui.min.js',
        'resources/themes/limitless/assets/js/application.js',
        'resources/themes/limitless/assets/js/gantt.js',
        'resources/themes/limitless/assets/js/raphael.js',
        'resources/themes/limitless/assets/js/shortcut.js',
    ], 'public/themes/limitless/js/async.js')
    .copy('resources/themes/limitless/assets/js/jquery-2.1.1.min.js', 'public/themes/limitless/js')
    .copy('resources/assets/js/timepicker.min.js', 'public/themes/limitless/js')
    .copy('resources/themes/limitless/assets/js/dataTables.buttons.min.js', 'public/themes/limitless/js')
    .copy('resources/themes/limitless/assets/js/vendor/datatables/buttons.server-side.js', 'public/vendor/datatables/buttons.server-side.js')
    .copy('resources/themes/limitless/assets/js/jqery.fieldsaddmore.min.js', 'public/themes/limitless/js')
    .copy('resources/themes/limitless/assets/js/bootstrap-toggle.js', 'public/themes/limitless/js');

    if (mix.inProduction()) {
        mix.version();
    }