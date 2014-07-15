app.routers.AppRouter = Backbone.Router.extend({
	routes: {
		''              : 'home',
		'home'          : 'home',
		'login'         : 'login',
		'logout'        : 'logout',
		'signup'        : 'signup',
		'room'          : 'room',
		'room_wait'     : 'room_wait',
		'match'         : 'match',
		'success_login' : 'success_login',
		// Default
		'*actions': 'defaultAction'
	},

	initialize: function () {
	},

	match: function () {
		console.log('shell');
		var shell_view  = new app.views.ShellView({ el: $('#dln_content') });
		shell_view.delegateEvents();

		console.log('match');
		var match_view = new app.views.MatchView();
		match_view.delegateEvents();
	},

	room: function () {
		console.log('shell');
		var shell_view  = new app.views.ShellView({ el: $('#dln_content') });
		shell_view.delegateEvents();

		console.log('room');
		var room_view = new app.views.RoomView();
		room_view.delegateEvents();
	},

	room_wait: function () {
		console.log( 'shell' );
		var shell_view  = new app.views.ShellView({ el: $('#dln_content') });
		shell_view.delegateEvents();

		console.log( 'room-wait' );
		var room_wait_view = new app.views.RoomWaitView({ el: $('#dln_content') });
		room_wait_view.delegateEvents();
	},

	home: function () {
		console.log('shell');
		var shell_view  = new app.views.ShellView({ el: $('#dln_content') });
		shell_view.delegateEvents();

		console.log('home');
		var home_view = new app.views.HomeView();
		home_view.delegateEvents();
	},

	login: function() {
		console.log( 'login' );
		var login_view = new app.views.LoginView({ el: $( '#dln_content') });
		login_view.delegateEvents();
	},

	logout: function () {
		console.log( 'logout' );
		$.mobile.loading( 'hide' );
		var user_helper  = app.helpers.userHelper.getInstance();
		user_helper.logout();
	},

	signup: function () {
		console.log('signup');
		var signup_view = new app.views.SignupView({ el: $('#dln_content') });
		signup_view.delegateEvents();
	}
});