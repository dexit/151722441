var app = {
	views: {},
	models: {},
	routers: {},
	utils: {},
	adapters: {}
};

$(document).on("ready", function () {
	app.utils.templates.load(["HomeView", "LoginView", "ShellView"],
	function () {
		console.log('callback');
		app.router = new app.routers.AppRouter();
		Backbone.history.start();
	});
});