var gulp = require('gulp'),
    sass = require('gulp-sass');

gulp.task('copy', function() {
  gulp.src('./**/*')
  .pipe(gulp.dest('../newtheme'));
});

gulp.task('default', function() {
  // place code for your default task here
});