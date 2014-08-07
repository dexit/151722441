(function($) {
	"use strict";
	
	var addSelectize = function () {
		if ( typeof( $.fn.selectize ) == 'function' ) {
			$('.dln-selectize').selectize();
		}
	};
	
	var addSelectMultiple = function () {
		if ( typeof( $.fn.selectize ) == 'function' ) {
			$('.dln-selectize-multi').each(function () {
				$(this).selectize({
					delimiter: ',',
					persist: false,
					create: function( input ) {
						return {
							value: input,
							text: capitalizeFirstLetter( input )
						}
					}
				});
			});
		}
	};
	
	var capitalizeFirstLetter = function( string ) {
		return string.charAt(0).toUpperCase() + string.slice(1);
	};
	
	$(document).ready(function () {
		addSelectize();
		addSelectMultiple();
	});
}(jQuery));