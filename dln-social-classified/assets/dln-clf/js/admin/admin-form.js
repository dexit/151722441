(function($) {
	"use strict";
	
	$(document).ready(function () {
		
		// Add select2
		$('.dln-select2').each(function () {
			$(this).select2();
		});
		
		// Add wpColorPicker
		if ( typeof( $.fn.ColorPicker ) == 'function' ) {
			$( '.dln-color-picker' ).each(function () {
				var that = this;
				$(this).ColorPicker({
					color: $(that).val(),
					onShow: function (colpkr) {
						$(colpkr).fadeIn(500);
						return false;
					},
					onHide: function (colpkr) {
						$(colpkr).fadeOut(500);
						return false;
					},
					onChange: function (hsb, hex, rgb) {
						$(that).val('#' + hex);
					}
				});
			});
		}
	});
}(jQuery));