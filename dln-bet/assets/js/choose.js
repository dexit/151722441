(function () {
	'use strict';
	
	$.DLN_Choose = $.DLN_Choose || {};
	
	$.DLN_Choose = function () {
		
	}
	
	$.DLN_Choose.addBet = function() {
		var _nonce = '';
		$.post(
			Dln_Ajax.ajaxurl,
			{
				action : 'dln_add_bet',
				_ajax_nonce: _nonce,
				post_id: post_id,
				user_id: user_id,
				multiple: multiple,
				cost: cost,
			},
			function (response) {
				var data = JSON.parse(response);
				if ( data.action == 'dln_add_bet' ) {
					console.log(data);
				} else {
					console.log(data);
				}
			}
		);
	};
	
	$(document).ready(function () {
		new $.DLN_Choose();
	});
}(jQuery));