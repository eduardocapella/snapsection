module.exports = function(grunt) {

    // Project configuration.
    // How it works:
    // 1. The "uglify" task will take the "src/js/script.js" file and create a minified version of it in the "src/js/script.min.js" file.
    // 2. The "cssmin" task will take the "src/css/*.css" files and create a minified version of them in the "src/css/*.min.css" files.
    // 3. The "watch" task will watch for changes in the "src/js/*.js" and "src/css/*.css" files and run the "uglify" and "cssmin" tasks respectively.

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        uglify: {
            options: {
                mangle: false
            },
            build: {
                files: [{
                    expand: true,
                    cwd: 'src/js',
                    src: ['*.js', '!*.min.js'],
                    dest: 'dist/js',
                    ext: '.min.js'
                }]
            }
        },

        cssmin: {
            target: {
                files: [{
                    expand: true,
                    cwd: 'src/css',
                    src: ['*.css', '!*.min.css'],
                    dest: 'dist/css',
                    ext: '.min.css'
                }]
            }
        },
        watch: {
            css: {
                files: ['src/css/*.css', '!src/css/*.min.css'],
                tasks: ['cssmin']
            },
            js: {
                files: ['src/js/*.js', '!src/js/*.min.js'],
                tasks: ['uglify']
            },
        }

    });

  
    /*
     * Load the plugin that provides the "uglify" task.
    */
    grunt.loadNpmTasks('grunt-contrib-uglify');

    /* 
     * Load the "Cssmin" task 
     * https://www.npmjs.com/package/grunt-contrib-cssmin
    */
    grunt.loadNpmTasks('grunt-contrib-cssmin');

    /* 
     * Load the plugin that provides the "watch" task.
     * https://www.npmjs.com/package/grunt-contrib-watch
    */
    grunt.loadNpmTasks('grunt-contrib-watch');
    
    grunt.registerTask('default', ['watch','uglify', 'cssmin']);

};