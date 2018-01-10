'use strict';
const gulp = require('gulp');
const gutil = require('gulp-util');
const zip = require('gulp-zip');
const bump = require('gulp-bump');
const vMap = require('vinyl-map');
const semver = require('semver');

const pkg = require('./package.json');

gulp.task('bump', () => {
  gulp.src(['package.json'])
  .pipe(bump())
  .pipe(gulp.dest('.'))

  gulp.src([
    'ponty-connector/ponty-connector.php'
  ])
  .pipe(bump())
  .pipe(vMap((contents, filename) => {
    // special special for the php:define version str
    let new_content = contents.toString();
    const re0 = new RegExp(/PNTY_VERSION', '(\d+.\d+.\d+)'/)
    const version_string = new_content.match(re0);
    const version_part = version_string[1];
    const new_version_part = semver.inc(version_part, 'patch');
    const new_version_string = `PNTY_VERSION', '${new_version_part}'`;
    new_content = new_content.replace(re0, new_version_string);
    return new_content;
  }))
  .pipe(gulp.dest('ponty-connector'))
});

gulp.task('build', () => {
  return gulp.src([
    'ponty-connector/**/*',
    '!ponty-connector/translate.sh'
  ], {base: '.'})
  .pipe(zip(`ponty-connector-${pkg.version}.zip`))
  .pipe(gulp.dest('release'));
});
