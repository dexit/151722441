app.views.LoginView =  Backbone.View.extend({
	initialize: function () {
		var that = this;
		app.utils.templates.get( 'LoginView', function (tpl) {
			that.render(tpl);
		} );
	},

	render: function (tpl) {
		var userHelper  = new app.helpers.userHelper();
		userHelper.login();
		var is_loggedin = userHelper.checkUserLoggedIn();
		if ( is_loggedin ) {
			window.location = '#home';
		}
		var params = {
			is_loggedin : is_loggedin
		};
		var template = _.template( tpl, params );
		this.$el.html( template );

		$('#dln_login_facebook').on('click', function (e) {
			e.preventDefault();
			userHelper.loginFB();
		});
	}
});