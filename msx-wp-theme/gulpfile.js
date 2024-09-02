const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const sourcemaps = require('gulp-sourcemaps');
const concat = require('gulp-concat');
const uglify = require('gulp-uglify');
const rename = require('gulp-rename');

// Paths to your source and destination files
const paths = {
    styles: {
        src: 'scss/**/*.scss',
        dest: 'css/'
    },
    scripts: {
        src: 'js/**/*.js',
        dest: 'js/'
    }
};

// Compile SCSS into CSS
function styles() {
    return gulp.src(paths.styles.src)
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError))
        .pipe(rename({ suffix: '.min' }))  // Rename to style.min.css
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(paths.styles.dest));
}

// Minify JavaScript
function scripts() {
    return gulp.src(paths.scripts.src)
        .pipe(sourcemaps.init())
        .pipe(concat('main.js'))
        .pipe(uglify())
        .pipe(rename({ suffix: '.min' }))  // Rename to main.min.js
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(paths.scripts.dest));
}

// Watch files for changes
function watchFiles() {
    gulp.watch(paths.styles.src, styles);
    gulp.watch(paths.scripts.src, scripts);
}

// Define complex tasks
const build = gulp.series(gulp.parallel(styles, scripts));

// Export tasks
exports.styles = styles;
exports.scripts = scripts;
exports.watch = watchFiles;
exports.build = build;
exports.default = gulp.series(build, watchFiles);