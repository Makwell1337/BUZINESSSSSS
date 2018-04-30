'use strict';

module.exports = function() {
  $.gulp.task('pages', function() {
    return $.gulp.src('./source/pages/**/*.*', { since: $.gulp.lastRun('pages') })
      .pipe($.gulp.dest($.config.root + '/'));
  });
};
