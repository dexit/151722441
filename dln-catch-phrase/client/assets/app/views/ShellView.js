app.views.ShellView = Backbone.View.extend({

	initialize: function () {
		var that = this;
		app.utils.templates.get( 'ShellView', function(tpl){
			that.render(tpl);
		});
	},

	render: function (tpl) {
		var userHelper  = new app.helpers.userHelper();
		var is_loggedin = userHelper.checkUserLoggedIn();
		var user        = userHelper.getCurrentUser();
		var params = {
			is_loggedin : is_loggedin,
			user: user
		};

		var template = _.template( tpl, params );
		this.$el.html(template);

		// Set logout action
		$('#dln_logout').on('click', function (e) {
			e.preventDefault();
			userHelper.logout();
		});

		return this;
	}
});