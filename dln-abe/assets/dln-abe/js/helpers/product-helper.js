(function($) {
	"use strict";
	
	$.DLN_Product_Helper = $.DLN_Product_Helper || {};
	
	$.DLN_Product_Helper.addSelectize = function () {
		if ( typeof( $.fn.selectize ) == 'function' ) {
			$('.dln-selectize').each(function () {
				if ( ! $(this).hasClass('dln-added') ) {
					$(this).selectize();
					$(this).addClass('dln-added');
				}
			});
		}
	};
	
	$.DLN_Product_Helper.addSelectMultiple = function () {
		if ( typeof( $.fn.selectize ) == 'function' ) {
			$('.dln-selectize-multi').each(function () {
				if ( ! $(this).hasClass('dln-added') ) {
					$(this).selectize({
						delimiter: '|',
						persist: false
					});
					$(this).addClass('dln-added');
				}
			});
		}
	};
	
	$(document).ready(function () {
		
	});
	
}(jQuery));