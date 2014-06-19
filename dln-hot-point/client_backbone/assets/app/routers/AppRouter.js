define(['jquery', 'underscore', 'backbone',
	'views/ShellView',
	'views/HomeView',
	'views/LoginView'
],function ($, _, Backbone, ShellView, HomeView, LoginView) {
	'use strict';

	var AppRouter = Backbone.Router.extend({
		routes: {
			''              : 'home',
			'login'         : 'login',
			'success_login' : 'success_login',
			// Default
			'*actions': 'defaultAction'
		},

		initialize: function () {
			var shellView  = new ShellView({ el: $('#dln_content') });
			shellView.delegateEvents();
		},

		home: function () {
			var homeView = new HomeView({ el: $('#main .container') });
			homeView.delegateEvents();
		},

		login: function() {
			console.log('ok');
			var loginView = new LoginView({ el: $('#main .container') });
			loginView.delegateEvents();
		},
	});

	return AppRouter;
});