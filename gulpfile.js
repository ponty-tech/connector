const gulp = require('gulp');
const gutil = require('gulp-util');
const zip = require('gulp-zip');
const bump = require('gulp-bump');

const pkg = require('./package.json');

gulp.task('bump', () => {
  return gulp.src([
    'package.json',
    'ponty-connector/ponty-connector.php'
  ])
  .pipe(bump())
  .pipe(gulp.dest('ponty-connector'))
});

gulp.task('build', () => {
  return gulp.src([
    'ponty-connector/**/*',
    '!ponty-connector/translate.sh'
  ], {base: '.'})
  .pipe(zip(`ponty-connector-${pkg.version}.zip`))
  .pipe(gulp.dest('.'));
});
