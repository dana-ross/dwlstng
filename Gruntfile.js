module.exports = function(grunt) {

	require('time-grunt')(grunt);

	// Project configuration.
	grunt.initConfig({

		pkg: grunt.file.readJSON('package.json'),

		phpcs: {
			"here": {
				dir: ['inc/**/*.php']
			},
			options     : {
				bin     : 'vendor/bin/phpcs',
				standard: 'vendor/wp-coding-standards/wpcs/WordPress-Extra/ruleset.xml',
				maxBuffer: 2000*1024
			}
		},

		phpmd: {
			"here": {
				dir: 'inc/**/*.php'
			},
			options     : {
				bin     : 'vendor/phpmd/phpmd/src/bin/phpmd',
				suffixes: 'php'
			}
		}

	});

	// Load Grunt plugins
	grunt.loadNpmTasks('grunt-phpcs');
	grunt.loadNpmTasks('grunt-phpmd');

	// Default task(s).
	grunt.registerTask('default', []);
	grunt.registerTask('test', ['phpcs','phpmd:here']);

};