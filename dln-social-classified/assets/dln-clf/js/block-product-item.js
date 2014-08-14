(function($) {
	"use strict";
	
	$(document).ready(function () {
		
		$('#dln_submit_product').on('click', function (e) {
			e.preventDefault();
			
			var product_data = {};
			
			// Get product images
			var image_ids = [];
			$('.dln-image-id').each(function() {
				var id = $(this).attr('value');
				if ( id ) {
					id = parseInt(id);
					image_ids.push(id);
				}
			});
			product_data.dln_image_id         = image_ids;
			
			// Get product title
			product_data.dln_product_title    = $('#dln_product_title').val();
			
			// Get product title
			product_data.dln_product_category = $('#dln_product_category').val();
			
			// Get product title
			product_data.dln_product_price    = $('#dln_product_price').val();
			
			// Get product description
			product_data.dln_product_desc     = $('#dln_product_desc').val();
			
			// Get product fields
			var fields = [];
			$('#dln_field_meta_block .row').each(function () {
				var meta  = {};
				var key   = $(this).find('.dln-field-meta-key').val();
				var value = $(this).find('.dln-field-meta-value').val();
				if ( key && value ) {
					meta.key   = key;
					meta.value = value;
					fields.push( meta );
				}
			});
			product_data.dln_product_fields = fields;
			
			$.ajax({
				url: dln_clf_params.dln_ajax_url,
				type: 'POST',
				data: {
					action           : 'dln_save_product_data',
					data             : product_data,
					'ig_nonce_check' : dln_clf_params.dln_nonce
				},
				success: function ( data ) {
					if ( data == '1' ) {
						//window.location.reload();
					} else {
						alert( 'Cant post multiple ajax request!' );
					}
				},
				error: function ( error ) {
					console.log( error );
				}
			});
		});
		
	});
}(jQuery));