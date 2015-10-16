var gulp = require('gulp');
var compass = require('gulp-compass');

var paths = {
  scss: ['resources/assets/scss/*.scss', 'resources/assets/scss/**/*.scss'],
};

gulp.task('compass', function() {
  gulp.src(['resources/assets/scss/*.scss', 'resources/assets/scss/**/*.scss'])
    .pipe(compass({
      config_file: 'config.rb',
      css: 'public/assets/css',
      sass: 'resources/assets/scss'
    }))
    .pipe(gulp.dest('./public/assets/css'));
});

gulp.task('watch', function() {
  gulp.watch(paths.scss, ['compass']);
});