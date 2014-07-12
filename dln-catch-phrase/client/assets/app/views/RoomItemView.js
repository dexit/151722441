app.views.RoomItemView = Backbone.View.extend({
	initialize: function () {
		var that = this;
		app.utils.templates.get( 'RootItemView', function (tpl) {
			that.render(tpl);
		} );
	},

	render: function (tpl) {
		var params = {

		};
		var template = _.template( tpl, params );
		this.$el.html( template );
		return this;
	}
});