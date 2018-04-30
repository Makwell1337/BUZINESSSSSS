'use strict';

module.exports = function() {
  $.gulp.task('php', function() {
    return $.gulp.src('./source/php/**/*.*', { since: $.gulp.lastRun('php') })
      .pipe($.gulp.dest($.config.root + '/php'));
  });
};
