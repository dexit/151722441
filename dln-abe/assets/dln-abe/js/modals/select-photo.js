(function($) {
	"use strict";
	
	var addUnveilForImages = function () {
		// Add unveil lib
		/*$("[data-toggle~=unveil]").unveil(0, function() {
            $(this).load(function() {
                $(this).addClass("unveiled");
            })
        })*/
        $("[data-toggle~=unveil]").each(function () {
        	$(this).addClass("unveiled");
        });
	};
	
	var addSelectButtonEvent = function () {
		$('.dln-select-photo').on('click', function (e) {
			e.preventDefault();
			
			if ( $('.dln-photo-items.active .dln-select-photo').first().length ) {
				var button = $('.dln-photo-items.active .dln-select-photo').first();
				button.removeClass('btn-success');
				button.addClass('btn-default');
				button.html('<i class="ico-close2"></i>');
			}
			$('.dln-photo-items').removeClass('active');
			
			var parent = $(this).closest('.dln-photo-items');
			parent.addClass('active');
			var button = $(parent).find('.dln-select-photo');
			button.removeClass('btn-default');
			button.addClass('btn-success');
			button.html('<i class="ico-checkmark"></i>');
		});
		
		$('.dln-photo-items').on('click', function (e) {
			e.preventDefault();
			
			$(this).find('.dln-select-photo').trigger('click');
		});
	};
	
	var renderPhotoItems = function( type, images, after, before ) {
		if ( ! type ) {
			type = 'upload';
		}
		
		if ( ! before ) {
			$('#dln_paging_group [data-action-type="before"]').hide();
		} else {
			$('#dln_paging_group [data-action-type="before"]').show();
			$('#dln_paging_group [data-action-type="before"]').data('code', before);
			$('#dln_paging_group [data-action-type="before"]').data('type', type);
		}
		
		if ( ! after ) {
			$('#dln_paging_group [data-action-type="after"]').hide();
		} else {
			$('#dln_paging_group [data-action-type="after"]').show();
			$('#dln_paging_group [data-action-type="after"]').data('code', after);
			$('#dln_paging_group [data-action-type="after"]').data('type', type);
		}
		
		var photo_tmpl = $.DLN_TemplatePhoto;
		var html       = '';
		$.each(images, function (key, image) {
			var image_html = photo_tmpl.replace('[photo_id]', image.id);
			image_html = image_html.replace('[photo_type]', type);
			image_html = image_html.replace(/\[photo_src\]/g, image.picture);
			html += image_html;
		});
		
		$('#dln_photo_wrapper .row').html(html);
		
		addUnveilForImages();
		addSelectButtonEvent();
	};
	
	var getFacebookPhotos = function ( action_type, page_code ) {
		$.ajax({
			url: dln_abe_params.dln_ajax_url,
			type: 'POST',
			data: {
				action           : 'dln_listing_image_facebook',
				action_type      : action_type,
				page_code        : page_code,
				'ig_nonce_check' : dln_abe_params.dln_nonce
			},
			success: function ( data ) {
				data = ( data ) ? JSON.parse( data ) : data;
				if ( data.status == 'success' ) {
					renderPhotoItems('facebook', data.images, data.after, data.before);
				} else {
					console.log( data );
				}
			},
			error: function ( error ) {
				console.log( error );
			}
		});
	};
	
	var getInstagramPhotos = function ( action_type, page_code ) {
		$.ajax({
			url: dln_abe_params.dln_ajax_url,
			type: 'POST',
			data: {
				action           : 'dln_listing_image_instagram',
				action_type      : action_type,
				max_id           : page_code,
				'ig_nonce_check' : dln_abe_params.dln_nonce
			},
			success: function ( data ) {
				data = ( data ) ? JSON.parse( data ) : data;
				if ( data.status == 'success' ) {
					renderPhotoItems('instagram', data.images, data.max_id, data.max_id);
				} else {
					console.log( data );
				}
			},
			error: function ( error ) {
				console.log( error );
			}
		});
	};
	
	var loadingPhotos = function ( select_val, action_type, code ) {
		switch(select_val) {
			case 'facebook':
				getFacebookPhotos( action_type, code );
			break;
			
			case 'instagram':
				getInstagramPhotos( action_type, code );
			break;
		}
	}
	
	var showLoading = function () {
		// Show loading indicator
		$('#dln_photo_wrapper .row').html( dln_abe_params.indicator );
	}
	
	$(document).ready(function () {
		$.DLN_Social_Helper.addLoginFBButton();
		$.DLN_Social_Helper.addLoginInstaButton();
		
		addUnveilForImages();
		
		// Add action for filter source photos
		$('#dln_btn_photos button').on('click', function (e) {
			e.preventDefault();
			
			var select_val = $(this).data('value');
			
			showLoading();
			loadingPhotos( select_val, '', '' );
		});
		
		$('#dln_paging_group a').on('click', function (e) {
			e.preventDefault();
			
			var type        = $(this).data('type');
			var code        = $(this).data('code');
			var action_type = $(this).data('action-type');
			
			if ( type && code ) {
				showLoading();
				loadingPhotos( type, action_type, code );
			}
		});
	});
}(jQuery));