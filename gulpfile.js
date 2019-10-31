const { src, dest, series, watch } = require('gulp');
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


const jsFn = () => {
  return src([
    'node_modules/prismjs/prism.js',
    'node_modules/prismjs/components/prism-markup-templating.js',
    'node_modules/prismjs/components/prism-php.js',
    'node_modules/prismjs/plugins/line-numbers/prism-line-numbers.js',
  ])
  .pipe(minify())
  .pipe(concat('main.js'))
  .pipe(dest(BUILD_DIR));
};


const sassFn = () => {
  return src([
    'node_modules/prismjs/themes/prism-okaidia.css',
    'node_modules/prismjs/plugins/line-numbers/prism-line-numbers.css',
    'scss/assemble.scss'
  ])
  .pipe(sass.sync({compressed: true}).on('error', sass.logError))
  .pipe(concat('style.css'))
  .pipe(autoprefixer())
  .pipe(cleanCSS())
  .pipe(dest(BUILD_DIR))
  .pipe(browserSync.stream());
};


const bsync = () => {
  browserSync.init({
    open: false,
    online: false,
    server: {
      baseDir: "./"
    }
  });
};


const watchFn = () => {
  watch('scss/*', sassFn);
  watch('*.html', () => {browserSync.reload()});
  watch('js/*', jsFn);
};


exports.default = series(jsFn, sassFn, bsync, watchFn);
