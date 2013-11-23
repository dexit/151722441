(function($) {
	$(function() {
		$(document).ready(function ($) {
			$.post(
			DLN_Ajax.ajaxurl,
            {
                action : 'dln_ajax_list_friend_fb',
                dln_nonce_check : DLN_Ajax._nonce,
                fbid : '100003959786482'
            },
            function( data ) {
                console.log(data);
            });
		});
	});
})(jQuery);