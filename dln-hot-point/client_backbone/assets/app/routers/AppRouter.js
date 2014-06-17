define(['jquery', 'underscore', 'backbone',
	'views/NavView',
	'views/HomeView',
	'views/LoginView'
],function ($, _, Backbone, NavView, HomeView, LoginView) {
	'use strict';

	var AppRouter = Backbone.Router.extend({
		routes: {
			''              : 'home',
			'login'         : 'login',
			'success_login' : 'success_login',
			// Default
			'*actions': 'defaultAction'
		},

		home: function () {
			var navView  = new NavView({ el: $('#content') });
			$(navView.el).insertBefore('#main');
			var homeView = new HomeView({ el: $('#main .container') });
			homeView.delegateEvents();
		},

		login: function() {
			console.log('ok');
			var navView  = new NavView();
			console.log(navView.render());
			//var loginView = new LoginView({ el: $('#main .container') });
			//loginView.delegateEvents();
		},
	});

	var initialize = function () {
		var app_router = new AppRouter;

		Backbone.history.start();
	};

	return {
		initialize: initialize
	};
});