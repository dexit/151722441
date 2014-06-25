var app = {
	views: {},
	models: {},
	routers: {},
	utils: {},
	helpers: {}
};

$(document).on('ready', function () {
	console.log('route');
	var router = new app.routers.AppRouter();
	Backbone.history.start();
});

window.addEventListener('load', function () {
	new FastClick(document.body);
}, false);
