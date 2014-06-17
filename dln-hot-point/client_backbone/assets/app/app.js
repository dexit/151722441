define(['jquery', 'underscore', 'backbone', 'route'], function ($, _, Backbone, Router) {
	var initialize = function () {
		Router.initialize();

		/*var app = {
			views: {},
			models: {},
			routers: {},
			utils: {},
			helpers: {}
		};

		$(document).on('ready', function () {

			app.utils.templates.load(['HomeView', 'LoginView', 'NavUserSettingView', 'NavView'], function () {
				app.router = new app.routers.AppRouter();
				Backbone.history.start();
			});
		});*/

	};
	return {
		initialize: initialize
	};
});

