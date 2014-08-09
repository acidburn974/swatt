// npm install grunt grunt-contrib-less grunt-contrib-watch grunt-contrib-coffee

module.exports = function(grunt) {
  grunt.initConfig({
    less: {
      development: {
        options: {
          compress: true,
          yuicompress: true,
          optimization: 2
        },
        files: {
          // target.css file: source.less file
          "css/main.css": "less/main.less"
        }
      }
    },
    coffee: {
        compile: {
            options: {
              bare: true
            },
            files: {
              "js/torrents.js": "coffee/torrents.coffee",
              "js/login.js": "coffee/login.coffee",
            }
        }
    },

    watch: {
      styles: {
        files: ['less/**/*.less'], // which files to watch
        tasks: ['less'],
        options: {
          nospawn: true
        }
      },
      scripts: {
        files: ['coffee/**/*.coffee'], // which files to watch
        tasks: ['coffee'],
        options: {
          nospawn: true
        }
      }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-coffee');

  grunt.registerTask('default', ['watch']);
};