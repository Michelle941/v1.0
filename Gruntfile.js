module.exports = function(grunt) {
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		concat: {
			options: {
				separator: ';'
			},
			dist: {
				src: (function() {
						var fs = require('fs');
						var arr = JSON.parse(fs.readFileSync('html/js/scripts.json', 'utf8'));
						var out = [];
						for(var i = 0; i < arr.length; i++) {
							out.push(arr[i].replace(arr[i], 'html/js/'+arr[i]))
						}
						return out;
					})(),
				dest: 'html/js/<%= pkg.name %>.js'
			}
		},
		uglify: {
			options: {
				banner: "/*! <%= grunt.template.today('dd-mm-yyyy HH:MM:ss') %> */\n"
			},
			dist: {
				files: {
					'html/js/<%= pkg.name %>.min.js': ['<%= concat.dist.dest %>']
				}
			}
		},
		imagemin: {
			png: {
				options: {
					optimizationLevel: 6
				},
				files: [
					{
						expand: true,
						cwd: 'html/images/',
						src: ['**/*.png'],
						dest: 'html/images/',
						ext: '.png'
					}
				]
			},
			jpg: {
				options: {
					progressive: true
				},
				files: [
					{
						expand: true,
						cwd: 'html/images/',
						src: ['**/*.jpg'],
						dest: 'html/images/',
						ext: '.jpg'
					}
				]
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-imagemin');

	grunt.registerTask('default', ['concat', 'uglify']);
	grunt.registerTask('prod', ['concat', 'uglify', 'imagemin']);

};