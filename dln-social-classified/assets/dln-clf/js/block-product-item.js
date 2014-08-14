(function($) {
	"use strict";
	
	$.DLN_Block_Item = $.DLN_Block_Item || {};
	
	$.DLN_Block_Item.count = 0;
	
	$.DLN_Block_Item.imageTemplate = function ( data ) {
		if ( ! data )
			return '';
		
		var tmpl = '';
		tmpl += '<div class="item thumbnail dln-uploaded-files col-md-2">';
		tmpl += '	<div class="media">';
		tmpl += '	<img alt="' + data.title +  '" width="100%" src="' + data.src + '" style="display: inline;">';
		tmpl += '	<a href="#" class="btn btn-primary btn-sm action-delete" data-upload_id="' + data.attach_id + '"><i class="ico-close2"></i></a></span>';
		tmpl += '	<input type="hidden" class="dln-image-id" name="dln_image_id[]" value="' + data.attach_id + '" />';
		tmpl += '	<div class="col-md-12 meta bottom darken">';
		tmpl += '		<a href="#" class="btn btn-default btn-sm">#1</a>';
		tmpl += '		<a href="#" class="btn btn-default btn-sm"><i class="ico-close2"></i></a>';
		tmpl += '	</div>';
		tmpl += '	</div>';
		tmpl += '</div>';
		
		return tmpl;
	};
	
	$.DLN_Block_Item.appendToImageWrapper = function ( action, data ) {
		var html = '';
		switch ( action ) {
			case 'from-pc':
				data = JSON.parse( data );
				html = $.DLN_Block_Item.imageTemplate( data );
				break;
			case 'from-fetch':
				data = JSON.parse( data );
				html = '';
				for( var i = 0; i < data.length; i++ ) {
					var obj       = {};
					obj.src       = data[i];
					obj.attach_id = '0';
					obj.title     = '';
					html += $.DLN_Block_Item.imageTemplate( obj );
				}
				break;
		}
		$('#dln-upload-imagelist .dln-upload-list').append( html );
	};
	
	$(document).ready(function () {
		
		$('#dln_fetch_url').on('click', function (e) {
			e.preventDefault();
			
			$('#dln_modal_fetch_url').modal('show');
		});
		
		// Add enter button
		$('#dln_url_fetch').on('keypress', function(e) {
		    if (e.which == 13) {
		        e.preventDefault();
		        $('#dln_submit_url_fetch').trigger('click');
		    }
		});
		
		$('#dln_submit_url_fetch').on('click', function (e) {
			e.preventDefault();
			
			var url = $('#dln_url_fetch').val();
			if ( ! url || url == 'http://' || url == 'https://' || url == 'http://www' || url == 'https://www' ) {
				alert( 'Please enter url for fetch images!' );
				return false;
			}
			
			$('#dln_modal_fetch_url').modal('hide');
			$(".dln-progress-text").show();
            $(".dln-progress-text .progress-bar").css( {'width': '50%'} );
			
			$.ajax({
				url: dln_clf_params.dln_ajax_url,
				type: 'POST',
				data: {
					action           : 'dln_fetch_images_from_url',
					url              : url,
					'ig_nonce_check' : dln_clf_params.dln_nonce
				},
				success: function ( data ) {
					if ( data ) {
						$(".dln-progress-text").hide();
						$.DLN_Block_Item.appendToImageWrapper( 'from-fetch', data );
					}
				},
				error: function ( error ) {
					console.log( error );
				}
			});
		});
		
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