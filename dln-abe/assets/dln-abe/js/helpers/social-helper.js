(function($) {
	"use strict";
	
	window.DLN_Social_Helper = window.DLN_Social_Helper || {};
	
	window.DLN_Social_Helper.addLoginInstaButton = function () {
		$('.dln-connect-insta').each(function () {
			$(this).on('click', function (e) {
				e.preventDefault();
				var insta_app_id = dln_abe_params.insta_app_id;
				var define_url   = dln_abe_params.insta_url;
				
				if ( insta_app_id && define_url ) {
					var redirect_uri = 'https://api.instagram.com/oauth/authorize/?client_id=' + insta_app_id + '&redirect_uri=' + define_url + '&response_type=code';
					window.location  = redirect_uri;
				}
			});
		});
	};
	
	window.DLN_Social_Helper.addLoginFBButton = function () {
		$('.dln-connect-fb').each(function () {
			$(this).on('click', function (e) {
				e.preventDefault();
				var app_id      = dln_abe_params.fb_app_id;
				var current_url = document.URL;
				var define_url  = dln_abe_params.fb_url;
				
				if ( app_id && define_url ) {
					var redirect_uri = 'https://www.facebook.com/dialog/oauth?client_id=' + app_id + '&redirect_uri=' + define_url + '&auth_type=rerequest&scope=user_photos&display=page&state=' + current_url;
					window.location  = redirect_uri;
				}
			});
		});
	};
	
}(jQuery));