'use strict';

module.exports = function() {
  $.gulp.task('slick', function() {
    return $.gulp.src('./source/slick/**/*.*', { since: $.gulp.lastRun('slick') })
      .pipe($.gulp.dest($.config.root + '/slick'));
  });
};
