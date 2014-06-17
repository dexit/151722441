define(function (require) {
	'use strict';

	var $           = require('jquery'),
		Backbone    = require('backbone');

	var AppRouter = Backbone.Router.extend({
		routes: {
			''              : 'home',
			'login'         : 'login',
			'success_login' : 'success_login',
			// Default
			'*actions': 'defaultAction'
		},

		home: function () {
			var NavView  = require('views/NavView');
			var HomeView = require( 'views/HomeView' );
			var navView  = new NavView({ el: $('#nav_view') });
			var homeView = new HomeView({ el: $('#home_view') });
			//homeView.delegateEvents();
		},

		/*login: function() {
			app.navView = new app.views.NavView();
			app.navView.render();
			if ( ! app.loginView ) {
				app.loginView = new app.views.LoginView();
				app.loginView.render();
			} else {
				console.log( 'reusing login view' );
				app.loginView.delegateEvents();
			}
		},*/
	});

	var initialize = function () {
		var app_router = new AppRouter;

		Backbone.history.start();
	};

	return {
		initialize: initialize
	};
});