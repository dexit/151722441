require.config({
	baseUrl: 'assets/app/',
	paths: {
		jquery: 'lib/jquery-1.9.1.min',
		underscore: 'lib/underscore-min',
		backbone: 'lib/backbone-min',
		text: 'lib/require-text',
		route: 'routers/AppRouter',
		fastclick: 'lib/fastclick',
		jquerymobile: '../3rd-party/jquery-mobile/jquery.mobile-1.4.2.min.js'
	},

	shim: {
		'jquery': {
			exports: '$'
		},
		'underscore': {
			exports: '_'
		},
		'backbone': {
			deps: ['underscore'],
			exports: 'Backbone'
		}
	}
});
require([
	'app',
	'jquerymobile'
], function (App, Mobile) {
	//$(document).on('load', function () {
		var mobile = new Mobile();
		App.initialize();
	//});
});