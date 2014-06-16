app.views.HomeView = Backbone.View.extend({

	initialize: function () {
		this.$el = $('body');
		this.navView = new app.views.NavView();
		this.navUserSettingView = new app.views.NavUserSettingView();
	},

	render: function () {
		$('.nav-view').html(this.navView.render());
		this.$el.append(this.template());
		var userHelper = app.helpers.user();
		if ( userHelper.checkUserLoggedIn() ) {
			$('.nav-user-setting', this.el).append( this.navUserSettingView.render().el );
		}
		return this;
	},
});