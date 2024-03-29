(function($) {
	"use strict";
	
	var changeColorCategory= function () {
		$('.dln-selection-box-item').each(function () {
			var color = $(this).data( 'toggle-color' );
			if ( $(this).hasClass( 'selected' ) ) {
				$(this).css({
					'background-color' : color,
					'color'            : 'none'
				});
			} else {
				$(this).css({
					'background-color' : 'none',
					'color' : color
				});
			}
		})
	};
	
	$(document).ready(function () {
		// Handle sub-items click
		$('.dln-selection-sub-item').on( 'click', function (e) {
			e.preventDefault();
			
			//$(this).toggleClass('selected');
			$('.dln-selection-sub-item').removeClass('selected');
			$(this).addClass('selected');
			var ids = '';
			$('.dln-selection-sub-item').each(function () {
				if ( $(this).hasClass( 'selected' ) ) {
					ids += $(this).data('id') + ',';
				}
			});
			if ( ids ) {
				$('#dln_fs_tag_sizes').val(ids);
			} else {
				$(this).addClass('selected');
			}
			
		} );
		// fs-category
		$('.dln-selection-box-item').on( 'click', function (e) {
			e.preventDefault();
			// Add selected class
			$('.dln-selection-box-item').removeClass('selected');
			$(this).addClass('selected');
			
			// Show/hide child elements
			var id = $(this).data('id');
			if ( id ) {
				$('.dln-selection-child .dln-selection-sub-item').hide();
				$('.dln-selection-child .dln-selection-sub-item').removeClass('selected');
				$('.dln-selection-child .dln-selection-sub-item[data-parent-id="' + id + '"]').show();
				$('.dln-selection-child .dln-selection-sub-item[data-parent-id="' + id + '"]').first().trigger('click');
				$('#dln_fs_category').val( id );
			}
			
			changeColorCategory();
		} );
		$('.dln-selection-box-item').first().trigger('click');
	});
}(jQuery));