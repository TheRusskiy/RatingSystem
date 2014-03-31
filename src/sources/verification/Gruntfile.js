// Generated on 2014-01-24 using generator-angular-fullstack 1.2.4
'use strict';

// # Globbing
// for performance reasons we're only matching one level down:
// 'test/spec/{,*/}*.js'
// use this if you want to recursively match all subfolders:
// 'test/spec/**/*.js'
require('coffee-script');

module.exports = function (grunt) {

  // Load grunt tasks automatically
  require('load-grunt-tasks')(grunt);

  // Time how long tasks take. Can help when optimizing build times
  require('time-grunt')(grunt);

  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-coffee');
  grunt.loadNpmTasks('grunt-concurrent');
  grunt.loadNpmTasks('grunt-shell');

  // Define the configuration for all the tasks
  grunt.initConfig({
    coffee: {
      compile: {
        expand: true,
        options: {
          sourceMap: true
        },
        // flatten: true,
        cwd: '',
        src: ['./scripts/**/*.coffee'],
        dest: '.',
        ext: '.js'
      }
    },
    // Project settings
    yeoman: {
      // configurable paths
      app: require('./bower.json').appPath || 'app',
      dist: 'dist'
    },
    watch: {
        coffeeCompile: {
          files: ['' +
              './scripts/**/*.coffee'
          ],
          tasks: ['coffee']
        },
//        clientJs: {
//          files: ['' +
//              './scripts/**/*.js'
//          ],
//          options: {
//            livereload: true
//          }
//        },
        compiledCss: {
            files: [
            './styles/{,*//*}*.css'
          ],
          options: {
//            debounceDelay: 2000,
            livereload: true
          }

        },
        compass: {
          files: ['./styles/{,*/}*.{scss,sass}'],
          tasks: ['compass:server']
        },
        gruntfile: {
          files: ['Gruntfile.js']
        },
        livereload: {
          files: [
            './views/**/*.html',
//            '{.tmp,<%= yeoman.app %>}/styles/{,*//*}*.css',
            './scripts/**/*.js',
            './images/**/*.{png,jpg,jpeg,gif,webp,svg}'
          ],

          options: {
            debounceDelay: 2000,
            livereload: true
          }
        },
        server: {
            files: ['.grunt/rebooted'],
            options: {
                // livereload: true
            }
        }
//        karmaTest: {
//            options: {
//        //              spawn: false
//            },
//            files: [
//                'test/client/**/*.{js,coffee}',
//                '<%= yeoman.app %>/scripts/{,*/}*.{js,coffee}'
//            ],
//            tasks: ['karma:continuous:run']
//        }
    },

    // Automatically inject Bower components into the app
    'bower-install': {
      app: {
        html: './views/index.html',
        ignorePath: '<%= yeoman.app %>/'
      }
    },

    // Compiles Sass to CSS and generates necessary files if requested
    compass: {
      options: {
        sassDir: './styles',
        cssDir: './styles',
//        generatedImagesDir: './images',
        imagesDir: './images',
        javascriptsDir: './scripts',
        fontsDir: './styles/fonts',
        importPath: './bower_components',
        httpImagesPath: '/images',
//        httpGeneratedImagesPath: '/images/generated',
        httpFontsPath: '/styles/fonts',
        relativeAssets: false,
        assetCacheBuster: false,
        raw: 'Sass::Script::Number.precision = 10\n'
      },
      dist: {
        options: {
//          generatedImagesDir: '<%= yeoman.dist %>/public/images/generated'
        }
      },
      server: {
        options: {
          debugInfo: true
        }
      }
    },

    // Allow the use of non-minsafe AngularJS files. Automatically makes it
    // minsafe compatible so Uglify does not destroy the ng references
    ngmin: {
      dist: {
        files: [{
          expand: true,
          cwd: './app/scripts',
          src: './**/*.js',
          dest: './app/scripts'
        }]
      }
    },

    // Copies remaining files to places other tasks can use
    copy: {
      dist: {
        files: [{
          expand: true,
          dot: true,
          cwd: '<%= yeoman.app %>',
          dest: '<%= yeoman.dist %>/public',
          src: [
            '*.{ico,png,txt}',
            '.htaccess',
            'bower_components/**/*',
            'images/{,*/}*.{webp}',
            'fonts/**/*',
            'scripts/*.swf'
          ]
        }, {
          expand: true,
          dot: true,
          cwd: '<%= yeoman.app %>/views',
          dest: '<%= yeoman.dist %>/views',
          src: '**/*.jade'
        }, {
          expand: true,
          cwd: '.tmp/images',
          dest: '<%= yeoman.dist %>/public/images',
          src: ['generated/*']
        }, {
          expand: true,
          cwd: 'app/styles',
          dest: '<%= yeoman.dist %>/public/styles',
          src: ['*.jpg', '*.gif', '*.png']
        }, {
          expand: true,
          dest: '<%= yeoman.dist %>',
          src: [
            'package.json',
            'server.js',
            'lib/**/*'
          ]
        }]
      },
      styles: {
        expand: true,
        cwd: '<%= yeoman.app %>/styles',
        dest: '.tmp/styles/',
        src: '{,*/}*.css'
      }
    },

    // Run some tasks in parallel to speed up the build process
    concurrent: {
      server: [
        'compass:server'
      ],
      test: [
        'compass'
      ],
      dist: [
        'compass:dist',
        'imagemin',
        'svgmin',
        'htmlmin'
      ],

        dev: {
            tasks: ['watch'],
            options: {
                logConcurrentOutput: true
            }
        }
    },

    // Test settings
    karma: {
        unit: {
            configFile: 'karma.conf.js',
            singleRun: true,
            autoWatch: false
        },
        continuous: {
            configFile: 'karma.conf.js',
            singleRun: false,
            background: true,
            autoWatch: false,
            browsers: ['PhantomJS']
        }
    }
  });

//  grunt.registerTask('express-keepalive', 'Keep grunt running', function() {
//    this.async();
//  });
//
//  grunt.registerTask('serve', function (target) {
//    if (target === 'dist') {
//      return grunt.task.run(['build', 'express:prod', 'open', 'express-keepalive']);
//    }
//
//    grunt.task.run([
//      'clean:server',
//      'bower-install',
//      'concurrent:server',
//      'autoprefixer',
//      'express:dev',
//      'open',
//      'watch'
//    ]);
//  });
//
//  grunt.registerTask('server', function () {
//    grunt.log.warn('The `server` task has been deprecated. Use `grunt serve` to start a server.');
//    grunt.task.run(['serve']);
//  });
//
//  grunt.registerTask('test', [
//    'clean:server',
//    'concurrent:test',
//    'autoprefixer',
//    'karma',
//    'mochaTest'
//  ]);

//    // On watch events configure mochaTest to run only on the test if it is one
//    // otherwise, run the whole testsuite
//    var defaultSimpleSrc = grunt.config('mochaTest.simple.src');
//    grunt.event.on('watch', function(action, filepath) {
//        grunt.config('mochaTest.simple.src', defaultSimpleSrc);
//        if (filepath.match('test/server')) {
//            grunt.config('mochaTest.simple.src', filepath);
//        }
//    });

  grunt.registerTask('test-watch', function(){
    grunt.option('force', true);
    grunt.task.run([
        'coffee',
        'concurrent:dev'
    ])
  });


  grunt.registerTask('default', [
      'test-watch'
  ]);
};
