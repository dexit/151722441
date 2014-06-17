define(['jquery', 'underscore', 'backbone',
	'text!tpl/NavView.html',
], function ($, _, Backbone, tpl) {
	'use strict';

	return Backbone.View.extend({

		initialize: function () {
			this.render();
		},

		render: function () {
			var params = {

			};
			var template = _.template( tpl, params );
			this.$el.html(template);
			return this;
		},
	});
});