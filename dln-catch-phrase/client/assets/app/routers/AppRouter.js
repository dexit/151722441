app.routers.AppRouter = Backbone.Router.extend({
	routes: {
		''              : 'home',
		'home'          : 'home',
		'login'         : 'login',
		'signup'        : 'signup',
		'room'          : 'room',
		'match'         : 'match',
		'success_login' : 'success_login',
		// Default
		'*actions': 'defaultAction'
	},

	initialize: function () {
	},

	match: function () {
		console.log('shell');
		var shellView  = new app.views.ShellView({ el: $('#dln_content') });
		shellView.delegateEvents();

		console.log('match');
		var matchView = new app.views.MatchView();
		matchView.delegateEvents();
	},

	room: function () {
		console.log('shell');
		var shellView  = new app.views.ShellView({ el: $('#dln_content') });
		shellView.delegateEvents();

		console.log('room');
		var roomView = new app.views.RoomView();
		roomView.delegateEvents();
	},

	home: function () {
		console.log('shell');
		var shellView  = new app.views.ShellView({ el: $('#dln_content') });
		shellView.delegateEvents();

		console.log('home');
		var homeView = new app.views.HomeView();
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