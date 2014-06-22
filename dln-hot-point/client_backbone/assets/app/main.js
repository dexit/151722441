require.config({
	paths: {
		jquery: 'lib/jquery-1.9.1.min',
		underscore: 'lib/underscore-min',
		backbone: 'lib/backbone-min',
		text: 'lib/require-text',
		route: 'routers/AppRouter',
		fastclick: 'lib/fastclick'
	},

	shim: {
		'jquery': {
			exports: '$'
		},
		'underscore': {
			exports: '_'
		},
		'backbone': {
			deps: ['underscore', 'jquery'],
			exports: 'Backbone'
		}
	}
});
require([
	'app'
], function (App) {
	//$(document).on('load', function () {
		App.initialize();
	//});
});