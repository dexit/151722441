app.views.HomeView =  Backbone.View.extend({

	initialize: function () {
		var that = this;
		app.utils.templates.get( 'HomeView', function(tpl){
			that.render(tpl);
		});
	},

	render: function (tpl) {
		var that = this;
		//var template = _.template(tpl);
		$('#main .container').html(tpl);
		//this.$el.html(template);

		// Set full width for container
		if ( ! $('#main .container').hasClass('dln-full-width') ) {
			$('#main .container').addClass('dln-full-width');
		}



		// Bind event load view
		$('body').trigger( 'on_after_render_home' );
	}
});