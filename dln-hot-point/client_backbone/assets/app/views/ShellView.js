define(['jquery', 'underscore', 'backbone',
	'text!tpl/ShellView.html',
	'helpers/user-helper'
], function ($, _, Backbone, tpl, userHelper) {
	'use strict';

	return Backbone.View.extend({

		initialize: function () {
			this.render();
		},

		render: function () {
			var is_loggedin = userHelper.checkUserLoggedIn();
			var user        = userHelper.getCurrentUser();
			var params = {
				is_loggedin : is_loggedin,
				user: user,
			};
			var template = _.template( tpl, params );
			this.$el.html(template);

			// Set logout action
			$('#dln_logout').on('click', function (e) {
				e.preventDefault();
				userHelper.logout();
			});

			return this;
		},
	});
});