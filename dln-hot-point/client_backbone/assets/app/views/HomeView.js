app.views.HomeView = Backbone.View.extend({

	initialize: function () {
		this.render();
	},

	render: function () {
		this.$el.html(this.template());
		return this;
		//var userHelper = app.helpers.user();
		//if ( userHelper.checkUserLoggedIn() ) {
		//	$('.nav-user-setting', this.el).append( this.navUserSettingView.render().el );
		//}
	}
});