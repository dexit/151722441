require.config({
	paths: {
		jquery: '../3rd-party/jquery/js/jquery.min',
		underscore: 'lib/underscore-min',
		backbone: 'lib/backbone-min',
		text: 'lib/require-text',
		route: 'routers/AppRouter',
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
	App.initialize();
});