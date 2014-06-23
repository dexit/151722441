define([ 'jquery', 'underscore', 'backbone',
	'text!tpl/HomeView.html'
], function ($, _, Backbone, tpl) {
	'use strict';

	return Backbone.View.extend({
		initialize: function () {
			this.render();
		},

		before_render: function () {

		},

		render: function () {
			var template = _.template(tpl);
			this.$el.html(template);

			// Set full width for container
			if ( ! $('#main .container').hasClass('dln-full-width') ) {
				$('#main .container').addClass('dln-full-width');
			}

			// Bind resize window to fill dln_map
			if ( $('#dln_map').length ) {
				$(window).on('resize', function () {
					var window_height = $(window).height();
					if ( window_height > 100 ) {
						$('#dln_map').height(window_height);
					} else {
						$('#dln_map').height(500);
					}
				});
				$(window).resize();
			}

			//var map = new L.Map('dln_map', {center: new L.LatLng( 51.51, -0.11 ), zoom: 9});
			//var googleLayer = new L.Google('ROADMAP');
			//map.addLayer(googleLayer);

			return this;
		},
	});
});