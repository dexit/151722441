app.views.LoginView = Backbone.View.extend({

	initialize: function () {
		this.$el = $('body');
	},

	render: function () {
		this.$el.append( this.template() );
		return this;
	},
});