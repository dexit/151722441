define([ 'jquery', 'underscore', 'backbone',
	'text!tpl/LoginView.html',
	'helpers/user-helper'
],function ($, _, Backbone, tpl, userHelper) {
	'use strict';

	return Backbone.View.extend({
		initialize: function () {
			this.render();
		},

		render: function () {
			var is_loggedin = userHelper.checkUserLoggedIn();
			var params = {
				is_loggedin : is_loggedin
			};
			var template = _.template( tpl, params );
			this.$el.html( template );
			return this;
		},
	});
});