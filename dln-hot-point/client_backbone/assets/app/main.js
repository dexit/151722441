require.config({
	paths: {
		jquery: '../3rd-party/jquery/js/jquery.min',
		underscore: 'lib/underscore-min',
		backbone: 'lib/backbone-min',
		text: 'lib/require-text',
		route: 'routers/AppRouter',
	},

	shim: {
		'backbone': {
			deps: ['underscore', 'jquery'],
			exports: 'Backbone'
		},
		'underscore': {
			exports: '_'
		}
	}
});
require([
	'app'
], function (App) {
	App.initialize();
});