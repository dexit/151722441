(function($) {
	"use strict";
	
	$.DLN_Facebook = $.DLN_Facebook || {};
	
	$.DLN_Facebook.loginFBUser = function( response ) {
		if ( dln_vars.is_logged_in != '1' ) {
      		// Hide the login button
      		if ( document.getElementById('loginButton') ) {
      			document.getElementById('loginButton').style.display = 'none';
          	}
          	
          	var access_token = response.authResponse.accessToken;
			var data = {
				action: 'send_access_token',
				security: dln_vars.nonce,
				access_token: access_token.toString()
    	  	};
			$.post( dln_vars.ajaxurl, data, function(response) {
				if ( response == '1' ) {
					location.reload();
				}
		   	} );
      	}
	};
	
	$(document).ready(function () {
		FB.init({
			appId: dln_vars.fb_app_id, 
			status: true,
			cookie: true,
			xfbml: true});
		
		FB.getLoginStatus(checkLoginStatus);

		jQuery('#loginButton').on( 'click', function () {
			FB.login(checkLoginStatus, {scope:'user_about_me,user_birthday,user_education_history,user_hometown,user_location,user_website,user_work_history,email,read_stream'});
		} );

		function checkLoginStatus(response) {
	        if(response && response.status == 'connected') {
	          	// Send access token using ajax for get facebook user information
	        	$.DLN_Facebook.loginFBUser( response );
	        } else {
	          	// Display the login button
	          	if ( document.getElementById('loginButton') ) {
	          		document.getElementById('loginButton').style.display = 'block';
				}
	        }
		}
	});
}(jQuery));