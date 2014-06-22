define(['jquery', 'underscore', 'backbone',
	'routers/AppRouter',
	'fastclick'
], function ($, _, Backbone, AppRouter, FastClick) {
	var initialize = function () {
		var app = {
			views: {},
			models: {},
			routers: {},
			utils: {},
			helpers: {}
		};

		window.addEventListener('load', function () {
			new FastClick(document.body);
		}, false);

		console.log('ready');
		// are we running in native app or in a browser?
		window.isphone = false;
		if(document.URL.indexOf("http://") === -1
				&& document.URL.indexOf("https://") === -1) {
			window.isphone = true;
		}

		console.log('app');
		var app_router = new AppRouter();
		Backbone.history.start();
		if( window.isphone ) {
			document.addEventListener("deviceready", onDeviceReady, true);
		} else {
			onDeviceReady();
		}

		function onDeviceReady() {

		}

	};
	return {
		initialize: initialize
	};
});
