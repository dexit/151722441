app.views.HomeView =  Backbone.View.extend({

	initialize: function () {
		var that = this;
		app.utils.templates.get( 'HomeView', function(tpl){
			that.render(tpl);
		});
	},

	loadEvents: function () {
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
		$('body').bind('on_load_backbone', function () {
			that.loadEvents();
		});



		// Bind resize window to fill dln_map
		if ( $('#dln_map').length ) {
			$(window).on('resize', function () {
				var window_height = $(window).height();
				console.log(window_height);
				if ( window_height > 100 ) {
					$('#dln_map').height(window_height - 50);
				} else {
					$('#dln_map').height(500);
				}
			});
			$(window).resize();
		}

		if ( $('.dln_check_point').length ) {
			$(window).on('resize', function () {
				var window_height = $(window).height();
				var window_width  =  $(window).width();

				/*if ( window_height > 50 ) {
					$('.dln-collection-points').css({
						top : window_height - 84,
						left: window_width / 2 - 32
					});
				}*/
			});
			$(window).resize();

			/*$('.dln_check_point').click(function () {
				var current_map = app.globals.map.getMap();
				current_map.locate({
					watch: true,
					locate: true,
					setView: false,
					maxZoom: 16,
					enableHighAccuracy: true
				});

				$(this).closest('.dln-collection-points').find('.dln-btn').toggleClass('open');
			});*/
		}
	},
});