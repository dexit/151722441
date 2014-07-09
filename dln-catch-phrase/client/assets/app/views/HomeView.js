app.views.HomeView = Backbone.View.extend({

	initialize: function () {
		var that = this;
		app.utils.templates.get( 'HomeView', function(tpl){
			that.render(tpl);
		});
	},

	render: function (tpl) {
		var that = this;
		//var template = _.template(tpl);
		$('#main .content').html(tpl);
		//this.$el.html(template);

		// Set full width for container
		if ( ! $('#main .content').hasClass('dln-full-width') ) {
			$('#main .content').addClass('dln-full-width');
		}

		// Bind event load view
		$('body').trigger( 'on_after_render_home' );
	}
});