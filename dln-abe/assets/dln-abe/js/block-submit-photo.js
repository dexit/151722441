(function($) {
	"use strict";
	
	var settingModal = function () {
		$(window).on('resize', function (e) {
			var height = $( window ).height();
			
			$('.dln-modal-resize').each(function () {
				var height_header = $(this).find('.modal-header').outerHeight();
				var height_footer = $(this).find('.modal-footer').outerHeight();
				if ( height_header <= 0 || ! height_footer <= 0 ) {
					height_header = height_footer = 70; 
				}
				var modal_height  = height - ( height_header + height_footer ) - 60;
				$(this).find('.modal-body').height( modal_height );
			});
		});
		$(window).trigger('resize');
	};
	
	$(document).ready(function () {
		settingModal();
		// Add select image action
		$('#dln_select_image').on('click', function (e) {
			e.preventDefault();

			$('#dln_modal_select_photo .modal-body').html(dln_abe_params.indicator);
			
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
					if ( data.status == 'success' ) {
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