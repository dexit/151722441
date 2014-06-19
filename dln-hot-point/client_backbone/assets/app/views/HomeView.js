define([ 'jquery', 'underscore', 'backbone',
	'text!tpl/HomeView.html'
], function ($, _, Backbone, tpl) {
	'use strict';

	return Backbone.View.extend({
		initialize: function () {

			//var NavUserSettingView = require('app/views/NavUserSettingView');

			//var navUserSettingView = new NavUserSettingView();
			this.render();
		},

		render: function () {
			var template = _.template(tpl);
			this.$el.html(template);
			//var userHelper = app.helpers.user();
			/*if ( userHelper.checkUserLoggedIn() ) {
			 $('.nav-user-setting', this.el).append( this.navUserSettingView.render().el );
			 }*/
			return this;
		},
	});
});