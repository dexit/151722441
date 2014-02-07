(function ($) {
	'use strict';
	$(document).ready(function () {
		$('#newchoose-submit').click(function (e) {
			e.preventDefault();
			var _nonce = $('#_ajax_nonce-dln-add-choose').val();
			var post_id = $('#post_ID').val();
			$.post(
	            Dln_Ajax.ajaxurl,
	            {
	                action 		: 'dln_add_choose',
	                _ajax_nonce : _nonce,
	                post_id		: post_id
	            },
	            function( data ) {
	                console.log(data);
	            })
		});
	});
}(jQuery));