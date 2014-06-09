/**
 * Created by dinhln on 6/5/2014.
 */
'use strict';
// Load Facebook JS SDK asynchronously
(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = "http://connect.facebook.net/vi_VN/sdk.js";
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

var client_id    = '251847918233636';
var redirect_uri = encodeURI('http://192.168.0.17:3000/auth/facebook/callback');

// Setup Facebook JS SDK
window.fbAsyncInit = function () {
	FB.init({
		appId      : client_id,
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
}

$(document).ready(function () {
	$('#dln_login_facebook').on('click', function (e) {
		var is_mobile = true;
		var display = ( is_mobile == true ) ? 'popup' : 'page';

		var auth_uri = encodeURI('https://www.facebook.com/dialog/oauth?client_id=' + client_id + '&redirect_uri=' + redirect_uri + '&scope=email&response_type=token&display=' + display);
		window.location =  auth_uri;
		/*FB.getLoginStatus(function(response) {
			if (response.status === 'connected') {
				FB.login(function (response) {
					statusChangeCallback(response);
				});
			} else if (response.status == 'not_authorized') {
				window.location =  auth_uri;
			} else {
				window.location =  auth_uri;
			}
		});*/
	});
});