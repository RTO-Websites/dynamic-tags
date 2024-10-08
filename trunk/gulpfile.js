var gulp = require('gulp'),
  util = require("gulp-util"),//https://github.com/gulpjs/gulp-util
  sass = require('gulp-sass')(require('sass')),//https://www.npmjs.org/package/gulp-sass
  minifycss = require('gulp-clean-css'),//https://github.com/scniro/gulp-clean-css
  rename = require('gulp-rename');//https://www.npmjs.org/package/gulp-rename

gulp.task('default', function (done) {
  // Admin
  var sassAdminFiles = ['Admin/scss/*.*'];
  gulp.src(sassAdminFiles)
    .pipe(sass({style: 'expanded'}))
    .pipe(gulp.dest("Admin/css"))
    .pipe(rename({suffix: '.min'}))
    .pipe(minifycss())
    .pipe(gulp.dest('Admin/css'));

  // Public
  var sassPublicFiles = ['Public/scss/*.*'];
  gulp.src(sassPublicFiles)
    .pipe(sass({style: 'expanded'}))
    .pipe(gulp.dest("Public/css"))
    .pipe(rename({suffix: '.min'}))
    .pipe(minifycss())
    .pipe(gulp.dest('Public/css'));

  done();
});
