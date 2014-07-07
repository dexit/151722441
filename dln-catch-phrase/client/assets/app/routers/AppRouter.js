app.routers.AppRouter = Backbone.Router.extend({
	routes: {
		''              : 'home',
		'login'         : 'login',
		'signup'        : 'signup',
		'success_login' : 'success_login',
		// Default
		'*actions': 'defaultAction'
	},

	initialize: function () {
	},

	home: function () {
		console.log('shell');
		var shellView  = new app.views.ShellView({ el: $('#dln_content') });
		shellView.delegateEvents();
		console.log('home');
		var homeView = new app.views.HomeView({ el: $('#main .container') });
		homeView.delegateEvents();
	},

	login: function() {
		console.log('login');
		var loginView = new app.views.LoginView({ el: $('#dln_content') });
		loginView.delegateEvents();
	},

	signup: function () {
		console.log('signup');
		var signupView = new app.views.SignupView({ el: $('#dln_content') });
		signupView.delegateEvents();
	}
});