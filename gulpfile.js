var gulp = require('gulp'),
    sass = require('gulp-sass');

gulp.task('sass', function() {
  return gulp.src('./assets/scss/style.scss')
  .pipe(sass({outputStyle: 'expanded'}).on('error', sass.logError))
  .pipe(gulp.dest('./'));
});

gulp.task('default', ['watch', 'sass']);

gulp.task('watch', function () {
  gulp.watch('./assets/scss/**/*.scss', ['sass']);
});