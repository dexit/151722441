(function($) {
	"use strict";
	
	$(document).ready(function () {
		if ( typeof ($.fn.selectize ) == 'function' ) {
			$('.dln-selectize').selectize();
		}
	});
}(jQuery));