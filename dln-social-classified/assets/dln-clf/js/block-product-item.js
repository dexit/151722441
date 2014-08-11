(function($) {
	"use strict";
	
	$(document).ready(function () {
		
		$.ajax({
			url: ig_wcss_settings_params.ig_ajax_url,
			type: 'POST',
			data: {
				action           : 'dln_save_product_data',
				'user_id'        : response.id,
				'user_name'      : response.name,
				'ig_nonce_check' : ig_wcss_settings_params.ig_nonce
			},
			success: function ( data ) {
				if ( data == '1' ) {
					window.location.reload();
				} else {
					console.log( data );
				}
			},
			error: function ( error ) {
				console.log( error );
			}
		});
	});
}(jQuery));