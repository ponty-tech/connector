const gulp = require('gulp');
const rename = require('gulp-rename');
const concat = require('gulp-concat');
const sass = require('gulp-sass');
const browserSync = require('browser-sync').create();

const autoprefixer = require('gulp-autoprefixer');
const cleanCSS = require('gulp-clean-css');

const uglify = require('uglify-js');
const composer = require('gulp-uglify/composer');
const pump = require('pump');
const minify = composer(uglify, console);


const BUILD_DIR = 'build';


gulp.task('js', () => {
  return gulp.src([
    'node_modules/prismjs/prism.js',
    'node_modules/prismjs/components/prism-php.js',
    'node_modules/prismjs/plugins/line-numbers/prism-line-numbers.js',
  ])
  .pipe(minify())
  .pipe(concat('main.js'))
  .pipe(gulp.dest(BUILD_DIR));
});


gulp.task('sass', () => {
  return gulp.src([
    'node_modules/prismjs/themes/prism-okaidia.css',
    'node_modules/prismjs/plugins/line-numbers/prism-line-numbers.css',
    'scss/assemble.scss'
  ])
  .pipe(sass.sync({compressed: true}).on('error', sass.logError))
  .pipe(concat('style.css'))
  .pipe(autoprefixer({browsers: ['last 2 versions']}))
  .pipe(cleanCSS())
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
  gulp.watch('js/*', ['js'])
});


gulp.task('default', ['js', 'sass', 'bs', 'watch']);
