var elixir = require('laravel-elixir');
var gulp = require('gulp');
var cleanCSS = require('gulp-clean-css');
var purify = require('gulp-purifycss');

elixir.config.publicPath = 'www';
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

gulp.task('purify', function() {
    return gulp.src('www/css/app.css')
        .pipe(purify(['./resources/views/**/*.*']))
        .pipe(cleanCSS({compatibility: 'ie8'}))
        .pipe(gulp.dest('./www/css'));
});

gulp.task('minify-css', function() {
    return gulp.src('www/css/app.css')
        .pipe(cleanCSS({compatibility: 'ie8'}))
        .pipe(gulp.dest('./www/css'));
});

elixir(function(mix) {
    mix.sass('app.scss');
});

elixir(function(mix) {
    mix.scriptsIn('resources/assets/js')
});

