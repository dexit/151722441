/**
 * Created by dinhln on 6/5/2014.
 */
'use strict';
$(document).ready(function () {
	//document.addEventListener('deviceready', onDeviceReady, false);
	//function onDeviceReady() {
		$('#dln_login_facebook').on('click', function (e) {
			var is_mobile = true;
			var width     = $(window).width(),
				height    = $(window).height(),
				path_url  = location.pathname,
				uuid      = $.now();
			var url_login = encodeURI( dlnWPServer + '/oauth/facebook?uuid=' + uuid );
			var popup = window.open(url_login, '_blank', 'width=' + width + ',height=' + height + ',scrollbars=0,toolbar=no,top=0,left=0');
			var popupTimer = window.setInterval(function () {
					if ( popup.closed !== false ) {
						window.clearInterval( popupTimer );
						$.ajax({
							url: dlnWPServer + '/wp-json/fbusers/' + uuid,
							dataType: 'json',
							type: 'GET',
							success: function (response) {
								if ( response ) {
									if ( response.ID ) {
										window.localStorage.setItem('user_json', JSON.stringify(response));
									}
								}
								window.location = '#/success_login';
							}
						});
					}
			}, 200);
		});
	//}
});