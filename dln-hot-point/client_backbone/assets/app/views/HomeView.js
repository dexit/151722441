define(function (require) {
	'use strict';

	var $        = require('jquery'),
		_        = require('underscore'),
		Backbone = require('backbone'),
		tpl      = require('text!tpl/HomeView.html'),
		template = _.template(tpl);

	return Backbone.View.extend({
		initialize: function () {

			//var NavUserSettingView = require('app/views/NavUserSettingView');

			//var navUserSettingView = new NavUserSettingView();
			this.render();
		},

		render: function () {
			//$('.nav-view').html(this.navView.render());
			this.$el.html(template);
			//var userHelper = app.helpers.user();
			/*if ( userHelper.checkUserLoggedIn() ) {
				$('.nav-user-setting', this.el).append( this.navUserSettingView.render().el );
			}*/
			return this;
		},
	});
});