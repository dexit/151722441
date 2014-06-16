var app = {
	views: {},
	models: {},
	routers: {},
	utils: {},
	helpers: {}
};

$(document).on('ready', function () {
	app.router = new app.routers.AppRouter();
	app.utils.templates.load(['HomeView', 'LoginView', 'NavUserSettingView', 'NavView'], function () {
		app.router = new app.routers.AppRouter();
		Backbone.history.start();
	});
});
