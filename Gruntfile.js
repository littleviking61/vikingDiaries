module.exports = function(grunt) {


    require('load-grunt-tasks')(grunt);

    grunt.initConfig({

        appComponents : [
            'js/lib/imagesloaded.pkgd.js',
            'js/lib/isotope.pkgd.js',
            'js/lib/jquery.fitvids.js',
            'js/lib/fotorama.js',
            'js/lib/jquery.magnific-popup.js',
            'js/lib/jquery.scrollTo.js',
            'js/lib/jquery.waypoints.js',
            'js/lib/sticky.js',
            'js/lib/inview.js',
            'js/lib/share-button.js',
            'js/lib/simple-likes-public.js'
        ],

        watch: {

            sass: {
                files: ['scss/**/*.{scss,sass}'],
                tasks: ['sass:dist'/*, 'rsync'*/],
            },

            // js : {
            //     files: ['js/**/*.js'],
            //         tasks: ['uglify'],
            //     options: {
            //         // livereload: true,
            //         // livereloadOnError: false,
            //         // spawn: false
            //     }
            // },

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
                    dest: "/var/www/html/laventurierviking/wp-content/themes/vikingDiaries2",
                    host: "laventurier@online",
                }
            }
        },

        uglify: {
            app: {
                files: {
                    'js/lib/app.min.js': '<%= appComponents %>',
                    'js/main.min.js': 'js/scripts.js'
                }
            }
        },

    });

    grunt.registerTask('default', ['watch']);
};