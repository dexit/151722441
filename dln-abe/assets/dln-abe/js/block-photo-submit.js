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
	
	var addTermPhoto = function () {
		$('#dln_post_perm button').on('click', function (e) {
			e.preventDefault();
			
			$('#dln_post_perm button').removeClass('active');
			$(this).addClass('active');
		});
		
		if ( $('#dln_post_perm button.active').length <= 0 ) {
			$('#dln_post_perm button').first().addClass('active');
		}
	};
	
	var addSubmitPhoto = function () {
		$('#dln_submit_photo').on('click', function (e) {
			e.preventDefault();
			
			var pic_url = $('#dln_add_status .media img').data('src');
			var message = $('#dln_photobabe_desc').val();
			message     = message.trim();
			var perm    = $('#dln_post_perm .active').data('value');
			
			if ( message == '' ) {
				alert( dln_abe_params.language.error_empty_message );
				return false;
			}
			
			$.ajax({
				url: dln_abe_params.dln_ajax_url,
				type: 'POST',
				data: {
					action           : 'dln_save_photo',
					pic_url          : pic_url,
					message          : message,
					perm             : perm,
					'ig_nonce_check' : dln_abe_params.dln_nonce
				},
				success: function ( data ) {
					data = ( data ) ? JSON.parse( data ) : data;
					
					console.log( data );
				},
				error: function ( error ) {
					console.log( error );
				}
			});
		});
	};
	
	$(document).ready(function () {
		settingModal();
		addTermPhoto();
		
		// Add select image action
		$('#dln_select_image').on('click', function (e) {
			e.preventDefault();

			$('#dln_modal_select_photo .modal-body').html(dln_abe_params.indicator);
			
			var block = 'modal-photo-select';
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