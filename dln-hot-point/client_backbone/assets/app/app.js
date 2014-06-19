define(['jquery', 'underscore', 'backbone',
	'routers/AppRouter'
], function ($, _, Backbone, AppRouter) {
	var initialize = function () {
		console.log('ok');
		var app = {
			views: {},
			models: {},
			routers: {},
			utils: {},
			helpers: {}
		};
		$(document).on('ready', function () {
			/*app.router = new app.routers.AppRouter();
			app.router.initialize
			app.utils.templates.load(['HomeView', 'LoginView', 'ShellView'], function () {
				app.router = new app.routers.AppRouter();
				Backbone.history.start();
			});*/
			var app_router = new AppRouter();
			console.log(app_router);
			Backbone.history.start();
		});

	};
	return {
		initialize: initialize
	};
});
