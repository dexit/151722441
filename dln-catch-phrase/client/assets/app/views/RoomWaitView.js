app.views.RoomWaitView = Backbone.View.extend({

	initialize: function () {
		var that = this;
		app.utils.templates.get( 'RoomWaitView', function ( tpl ) {
			that.render( tpl );
		} );
	},

	render: function ( tpl ) {
		var that = this;
		$('#main .content').html( tpl );

		return this;
	}

});