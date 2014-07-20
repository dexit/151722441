(function($) {
	"use strict";
	
	var changeColorCategory= function () {
		$('.dln-selection-box-item').each(function () {
			var color = $(this).data( 'color-toggle' );
			if ( $(this).hasClass( 'selected' ) ) {
				$(this).css({
					'background-color' : color
				});
			} else {
				$(this).css({
					'color' : color
				});
			}
		})
	}
	
	$(document).ready(function () {
		if ( typeof ($.fn.selectize ) == 'function' ) {
			$('.dln-selectize').selectize();
		}
		
		// fs-category
		changeColorCategory();
		$('.dln-selection-box-item').on( 'click', function (e) {
			e.preventDefault();
			$('.dln-selection-box-item').removeClass('selected');
			$(this).addClass('selected');
			changeColorCategory();
		} );
	});
}(jQuery));