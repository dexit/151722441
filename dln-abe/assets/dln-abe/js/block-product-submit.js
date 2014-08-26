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
	
	var addSubmitPhoto = function () {
		$('#dln_submit_product').on('click', function (e) {
			e.preventDefault();
			
			var image_data = $('#dln_add_status .media img').data('src');
			var title      = $('#dln_product_title').val();
			var desc       = $('#dln_product_desc').val();
			var category   = $('#dln_product_category').val();
			var price      = $('#dln_product_price').val();
			desc           = desc.trim();
			
			// Process product attributes
			var product_atts = [];
			if ( $('.dln-hidden-data.dln-active').length ) {
				$('.dln-hidden-data.dln-active').each(function () {
					var key = $(this).data('relate-id');
					var value = $(this).find('.dln-meta-value').val();
					if ( key && value ) {
						var obj   = {};
						obj.name  = key;
						obj.value = value;
						product_atts.push( obj );
					}
				});
			}
			
			if ( desc == '' ) {
				alert( dln_abe_params.language.error_empty_message );
				return false;
			}
			
			var data           = {};
			data.image_data    = image_data;
			data.product_title = title;
			data.product_desc  = desc;
			data.product_cat   = category;
			data.product_price = price;
			data.product_attrs = product_atts;
			
			$.ajax({
				url: dln_abe_params.dln_ajax_url,
				type: 'POST',
				data: {
					action     : 'dln_save_product',
					data       : data,
					'security' : dln_abe_params.dln_nonce_save_product
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
	
	var addButtonAttrProduct = function() {
		$('.dln-add-attr').on('click', function (e) {
			e.preventDefault();
			
			var select_val = $('#dln_product_attribute').val();
			if ( $('.dln-hidden-data[data-relate-id="' + select_val + '"]').length ) {
				var field = $('.dln-hidden-data[data-relate-id="' + select_val + '"]');
				field.show();
				field.addClass('dln-active');
			}
		});
	};
	
	var addCloseAttrProduct = function () {
		$('.dln-field-close').on('click', function (e) {
			e.preventDefault();
			
			var parent_wrapper = $(this).closest('.dln-hidden-data');
			parent_wrapper.hide();
			parent_wrapper.removeClass('dln-active');
		});
	};
	
	$(document).ready(function () {
		window.DLN_Product_Helper.addSelectize();
		window.DLN_Product_Helper.addSelectMultiple();
		settingModal();
		addSubmitPhoto();
		addButtonAttrProduct();
		addCloseAttrProduct();
		
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