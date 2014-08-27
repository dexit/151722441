(function($) {
	"use strict";
	
	window.DLN_Product_Helper = window.DLN_Product_Helper || {};
	
	window.DLN_Product_Helper.addSelectize = function () {
		if ( typeof( $.fn.selectize ) == 'function' ) {
			$('.dln-selectize').each(function () {
				if ( ! $(this).hasClass('dln-added') ) {
					$(this).selectize();
					$(this).addClass('dln-added');
				}
			});
		}
	};
	
	window.DLN_Product_Helper.addSelecizeCreate = function () {
		if ( typeof( $.fn.selectize ) == 'function' ) {
			$('.dln-selectize-create').each(function() {
				if ( ! $(this).hasClass('dln-added') ) {
					$(this).selectize({
						delimiter: '|',
						persist: false,
						create: function( input ) {
							return {
								value: input,
								text: capitalizeFirstLetter( input )
							}
						}
					});
					$(this).addClass('dln-added');
				}
			});
		}
	};
	
	window.DLN_Product_Helper.addSelectMultiple = function () {
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
	
	var capitalizeFirstLetter = function( string ) {
		return string.charAt(0).toUpperCase() + string.slice(1);
	};
	
	$(document).ready(function () {
		
	});
	
}(jQuery));