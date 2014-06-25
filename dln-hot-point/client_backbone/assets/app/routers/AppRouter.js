app.routers.AppRouter = Backbone.Router.extend({
	routes: {
		''              : 'home',
		'login'         : 'login',
		'success_login' : 'success_login',
		// Default
		'*actions': 'defaultAction'
	},

	initialize: function () {
		console.log('shell');
		var shellView  = new app.views.ShellView({ el: $('#dln_content') });
		shellView.delegateEvents();
	},

	home: function () {
		console.log('home');
		var homeView = new app.views.HomeView({ el: $('#main .container') });
		homeView.delegateEvents();
	},

	login: function() {
		console.log('login');
		var loginView = new app.views.LoginView({ el: $('#main .container') });
		loginView.delegateEvents();
	},
});