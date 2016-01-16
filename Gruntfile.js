module.exports = function(grunt) {


    require('load-grunt-tasks')(grunt);

    grunt.initConfig({

        watch: {

            sass: {
                files: ['scss/**/*.{scss,sass}'],
                tasks: ['sass:dist', 'rsync'],
            },

            js : {
                files: ['js/**/*.js'],
                tasks: ['jshint'],
                options: {
                    livereload: true,
                    livereloadOnError: false,
                    spawn: false
                }
            },

            other: {
                files: ['**/*.php', 'css/*.css'],
                options: {
                    livereload: true,
                    livereloadOnError: false,
                    spawn: false
                }
            }
        },

        jshint: {
            all: ['js/**/*.js', '!js/foundation/**/*.js', '!js/vendor/**/*.js']
        },

        sass: {
            dist: {
                files: {
                    'css/style.css': 'scss/style.scss'
                }
            },
            options: {
                compass: true,
                //quiet: true,
                style: 'nested',
                require: [ 'susy', 'font-awesome-sass']
            }
        },

        rsync: {
            options: {
                // args: ["-q"],
                //exclude: [".git*","assets/less","node_modules"],
                recursive: true
            },
            dist: {
                options: {
                    // src: ["./assets/css/dw-timeline-pro-flat.min.css", "./assets/css/dw-timeline-pro-flat.min.css.map"],
                    // dest: "/var/www/html/laventurierviking/wp-content/themes/dw-timeline-pro/assets/css/",

                    src: "./css",
                    dest: "/var/www/html/laventurierviking-dev/wp-content/themes/vikingDiaries",
                    host: "laventurier@onlinet",
                }
            }
        },

    });

    grunt.registerTask('default', ['watch']);
};