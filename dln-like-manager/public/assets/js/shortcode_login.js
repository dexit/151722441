jQuery.noConflict();
(function($) {
	$(function() {
		
		var _do_facebook_login = function() {
			var facebook_auth = $('#social_login_facebook_auth');
			var client_id = facebook_auth.find('input[type=hidden][name=client_id]').val();
			var redirect_uri = facebook_auth.find('input[type=hidden][name=redirect_uri]').val();

			if(client_id == "") {
				alert("Social Connect plugin has not been configured for this provider");
			} else {
				window.open('https://graph.facebook.com/oauth/authorize?client_id=' + client_id + '&redirect_uri=' + redirect_uri + '&scope=email',
				'','scrollbars=no,menubar=no,height=400,width=800,resizable=yes,toolbar=no,status=no');
			}
		};

		// Close dialog if open and user clicks anywhere outside of it
		//function overlay_click_close() {
			//if (closedialog) {
				//_social_connect_already_connected_form.dialog('close');
			//}
			//closedialog = 1;
		//}

		$(".social_login_login_facebook").click(function() {
			_do_facebook_login();
		});
	});
})(jQuery);


window.wp_social_login = function(config) {
	jQuery('#login_form').unbind('submit.simplemodal-login');

	var form_id = '#login_form';

	if(!jQuery('#login_form').length) {
		// if register form exists, just use that
		if(jQuery('#registerform').length) {
			form_id = '#registerform';
		} else {
			// create the login form
			var login_uri = jQuery("#social_login_login_form_uri").val();
			jQuery('body').append("<form id='login_form' method='post' action='" + login_uri + "'></form>");
			jQuery('#login_form').append("<input type='hidden' id='redirect_to' name='redirect_to' value='" + window.location.href + "'>");
		}
	}

	jQuery.each(config, function(key, value) {
		jQuery("#" + key).remove();
		jQuery(form_id).append("<input type='hidden' id='" + key + "' name='" + key + "' value='" + value + "'>");
	});  

	if(jQuery("#simplemodal-login-form").length) {
		var current_url = window.location.href;
		jQuery("#redirect_to").remove();
		jQuery(form_id).append("<input type='hidden' id='redirect_to' name='redirect_to' value='" + current_url + "'>");
	}

	jQuery(form_id).submit();
}
