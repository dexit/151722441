app.routers.AppRouter = Backbone.Router.extend({
	routes: {
		''              : 'home',
		'login'         : 'login',
		'success_login' : 'success_login',
		// Default
		'*actions': 'defaultAction'
	},

	initialize: function () {

	},

	home: function () {
		console.log('home');
		app.shellView = new app.views.ShellView({ el: $('#dln_content') });
		app.shellView.delegateEvents();
		app.homeView = new app.views.HomeView({ el: $('#main .container') });
		app.homeView.delegateEvents();
	},

	login: function() {
		console.log('login');
		app.loginView = new app.views.LoginView({ el: $('#main .container') });
		app.loginView.delegateEvents();
	}

});