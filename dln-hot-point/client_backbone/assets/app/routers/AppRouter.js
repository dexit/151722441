app.routers.AppRouter = Backbone.Router.extend({
	routes: {
		''              : 'home',
		'login'         : 'login',
		'success_login' : 'success_login'
	},

	initialize: function () {

	},

	home: function () {
		if ( ! app.homeView ) {
			app.homeView = new app.views.HomeView();
			app.homeView.render();
		} else {
			console.log('reusing home view');
			app.homeView.delegateEvents();
		}
	},

	login: function() {
		app.navView = new app.views.NavView();
		app.navView.render();
		if ( ! app.loginView ) {
			app.loginView = new app.views.LoginView();
			app.loginView.render();
		} else {
			console.log( 'reusing login view' );
			app.loginView.delegateEvents();
		}
	}
});