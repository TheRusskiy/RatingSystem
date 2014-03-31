module.exports = function(grunt) {
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.initConfig({
    watch: {
      options: {
        livereload: 35729,
      },
      html: {
        files: ['*/*.html'],
        tasks: []
      },
      css: {
        files: ['*/*.css'],
        tasks: []
      }
    }
  });
  grunt.loadNpmTasks('grunt-contrib-watch');
};