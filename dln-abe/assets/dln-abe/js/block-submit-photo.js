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
	
	var addUnveilLib = function () {
		// Add unveil lib
		$("[data-toggle~=unveil]").unveil(0, function() {
            $(this).load(function() {
                $(this).addClass("unveiled");
            })
        })
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
		
		// Add select photo button action
		$('#dln_modal_select_photo .dln-select').on('click', function(e) {
			e.preventDefault();
			
			if ( $('.dln-photo-items.active').length ) {
				var active_elm = $('.dln-photo-items.active').first();
				var img_url    = $(active_elm).find('img').data('src');
				
				if ( img_url ) {
					var elm_container = $('#dln_add_status .media');
					$(elm_container).find('img').remove();
					
					// Create new img tag
					var img_tag = $('<img />', {
						'src'         : img_url,
						'data-src'    : img_url,
						'data-toggle' : 'unveil'
					});
					
					$(elm_container).append( img_tag );
					$(elm_container).find('.overlay').removeClass('show');
					addUnveilLib();
					// Show modal last active
					$('.modal.in').last().modal('hide');
				}
			}
		});
	});
}(jQuery));