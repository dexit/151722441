app.views.MatchView = Backbone.View.extend({

	initialize: function () {
		var that = this;
		app.utils.templates.get( 'MatchView', function ( tpl ) {
			that.render( tpl );
		} );
	},

	render: function ( tpl ) {
		var that = this;
		$('#main .content').html( tpl );
	}
});