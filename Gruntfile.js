module.exports = function(grunt) {

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        watch: {
            sass: {
                files: ['src/js/script.js'],
                tasks: ['uglify']
            }
        },

        uglify: {
            options: {
                // banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
            },
            build: {
                src: 'src/js/script.js',
                dest: 'src/js/script.min.js'
            }
        },

        cssmin: {
            target: {
                files: [{
                    expand: true,
                    cwd: 'src/css',
                    src: ['*.css', '!*.min.css'],
                    dest: 'src/css',
                    ext: '.min.css'
                }]
            }
          }

    });

  
    /*
     * Load the plugin that provides the "uglify" task.
    */
    grunt.loadNpmTasks('grunt-contrib-uglify');

    /* 
     * Load the plugin that provides the "watch" task.
     * https://www.npmjs.com/package/grunt-contrib-watch
    */
    grunt.loadNpmTasks('grunt-contrib-watch');

    /* 
     * Load the "Cssmin" task 
     * https://www.npmjs.com/package/grunt-contrib-cssmin
    */
    grunt.loadNpmTasks('grunt-contrib-cssmin');

};