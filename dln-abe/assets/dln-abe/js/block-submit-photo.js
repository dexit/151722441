(function($) {
	"use strict";
	
	$(document).ready(function () {
		// Add select image action
		$('#dln_select_image').on('click', function (e) {
			e.preventDefault();

			var block = 'modal-select-photo';
			$.ajax({
				url: dln_abe_params.dln_ajax_url,
				type: 'POST',
				data: {
					action           : 'dln_load_block_modal',
					block            : block,
					'ig_nonce_check' : dln_abe_params.dln_nonce
				},
				success: function ( data ) {
					data = ( data ) ? JSON.parse( data ) : data;
					if ( data.code == 'success' ) {
						$('#dln_modal_select_photo .modal-body').html( data.content );
					} else {
						console.log( data );
					}
				},
				error: function ( error ) {
					console.log( error );
				}
			});
			
			$('#dln_modal_select_photo').modal('show');
		});
	});
}(jQuery));