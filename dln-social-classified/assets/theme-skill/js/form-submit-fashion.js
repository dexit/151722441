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
	
	var capitalizeFirstLetter = function( string ) {
		return string.charAt(0).toUpperCase() + string.slice(1);
	};
	
	var addSelectMultiple = function () {
		$('.dln-select-multi').each(function () {
			$(this).selectize({
				delimiter: ',',
				persist: false,
				maxItems: 1,
				create: function( input ) {
					return {
						value: input,
						text: capitalizeFirstLetter( input )
					}
				}
			});
		});
	};
	
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
		
		// Add selectize multiple
		addSelectMultiple();
	});
}(jQuery));