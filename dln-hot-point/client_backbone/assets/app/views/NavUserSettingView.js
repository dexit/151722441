app.views.NavUserSettingView = Backbone.View.extend({
	render: function () {
		this.$el.html( this.template() );
		return this;
	},

	back: function(event) {
		window.history.back();
		return false;
	}

});