const gulp = require('gulp');
const rename = require('gulp-rename');
const sass = require('gulp-sass');
const browserSync = require('browser-sync').create();


const BUILD_DIR = 'build';


gulp.task('sass', () => {
  return gulp.src('scss/assemble.scss')
  .pipe(sass.sync().on('error', sass.logError))
  .pipe(rename('style.css'))
  .pipe(gulp.dest(BUILD_DIR))
  .pipe(browserSync.stream());
});


gulp.task('bs', () => {
  browserSync.init({
    open: false,
    online: false,
    server: {
      baseDir: "./"
    }
  });
});


gulp.task('watch', () => {
  gulp.watch('scss/*', ['sass'])
  gulp.watch('*.html', () => {
    browserSync.reload();
  });
});


gulp.task('default', ['sass', 'bs', 'watch']);
