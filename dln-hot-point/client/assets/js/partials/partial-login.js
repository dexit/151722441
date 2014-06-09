/**
 * Created by dinhln on 6/5/2014.
 */
'use strict';
// Load Facebook JS SDK asynchronously
/*(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = "http://connect.facebook.net/vi_VN/sdk.js";
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

// Setup Facebook JS SDK
window.fbAsyncInit = function () {
	FB.init({
		appId      : '1446113338979798',
		cookie     : true,  // enable cookies to allow the server to access
		// the session
		xfbml      : true,  // parse social plugins on this page
		oauth      : true,
		version    : 'v2.0' // use version 2.0
	});

	// set callback events
	FB.Event.subscribe('auth.login', function(response) {
		if ( response.authResponse ) {
			console.log(response.authResponse.accessToken);
			alert(response.authResponse.accessToken);
		}
	});
};

function statusChangeCallback(response) {
	if ( response.status === 'connected' ) {
		// get user information
		FB.api('/me', function (user_response) {
			var user = window.localStorage.getItem( 'user' );
			var user_infor = JSON.stringify(user_response);
			console.log(user_infor);
			if ( ! user ) {
				window.localStorage.setItem( 'user', user_infor );
			}
		});
	} else if (response.status === 'not_authorized') {
		console.log('not_authorized');
		window.location = auth_uri;
	} else {
		console.log('otherwise');
		window.location = auth_uri;
	}
}*/

$(document).ready(function () {
	$('#dln_login_facebook').on('click', function (e) {
		var is_mobile = true;
		var width  = $(window).width(),
			height = $(window).height(),
			path_url  = location.pathname;

		var url_login = encodeURI( dlnServerUrl + '/auth/facebook?path_url=' + path_url );
		window.open(url_login, '_blank', 'width=' + width + ',height=' + height + ',scrollbars=0,toolbar=no,top=0,left=0');

		/*FB.getLoginStatus(function(response) {
			if (response.status === 'connected') {
				statusChangeCallback(response);
			} else if (response.status == 'not_authorized') {
				window.location =  auth_uri;
			} else {
				window.location =  auth_uri;
			}
		});*/
	});
});