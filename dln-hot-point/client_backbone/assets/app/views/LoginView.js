app.views.LoginView = Backbone.View.extend({

	initialize: function () {
		this.render();
	},

	render: function () {
		var is_loggedin = app.helpers.user.checkUserLoggedIn();
		var params = {
			is_loggedin : is_loggedin
		};
		var template = _.template( tpl, params );
		this.$el.html( this.template(), params );
		return this;
	},
});