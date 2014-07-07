app.views.LoginView =  Backbone.View.extend({
	initialize: function () {
		var that = this;
		app.utils.templates.get( 'LoginView', function (tpl) {
			that.render(tpl);
		} );
	},

	render: function (tpl) {
		var userHelper  = new app.helpers.userHelper();
		var is_loggedin = userHelper.checkUserLoggedIn();
		var params = {
			is_loggedin : is_loggedin
		};
		var template = _.template( tpl, params );
		this.$el.html( template );

		$('#dln_login_facebook').on('click', function (e) {
			e.preventDefault();
			userHelper.login();
		});
	}
});