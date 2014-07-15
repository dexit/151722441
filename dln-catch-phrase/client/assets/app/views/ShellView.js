app.views.ShellView = Backbone.View.extend({

	initialize: function () {
		var that = this;
		app.utils.templates.get( 'ShellView', function(tpl){
			that.render(tpl);
		});
	},

	render: function (tpl) {
		var user_helper  = app.helpers.userHelper.getInstance();
		var is_loggedin  = user_helper.checkUserLoggedIn();
		var user         = user_helper.getCurrentUser();
		var params = {
			is_loggedin : is_loggedin,
			user: user
		};

		// Check user login?
		if ( ! is_loggedin ) {
			window.location = '#login';
		}

		var template = _.template( tpl, params );
		this.$el.html(template);

		// Set logout action
		$('#dln_logout').on('click', function (e) {
			e.preventDefault();
			user_helper.logout();
		});

		return this;
	}
});