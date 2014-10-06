(function($) {
	"use strict";
	
	window.DLN_Helpers = window.DLN_Helpers || {};
	
	String.prototype.rot13 = function(){
	    return this.replace(/[a-zA-Z]/g, function(c){
	        return String.fromCharCode((c <= "Z" ? 90 : 122) >= (c = c.charCodeAt(0) + 13) ? c : c - 26);
	    });
	};
	
	window.DLN_Helpers.encode = function ( str ) {
		if ( ! str )
			return false;

		str = str + '|' + Math.floor((Math.random() * 10000) + 1);
		str = str.rot13();
		
	    return str;
	};
	
	$(document).ready(function () {
		if ( typeof( $.fn.selectize ) == 'function' ) {
			$('.dln-selectize').each(function () {
				if ( ! $(this).hasClass('dln-added') ) {
					$(this).selectize();
					$(this).addClass('dln-added');
				}
			});
		}
		
		if ( typeof( $.fn.selectize ) == 'function' ) {
			$('.dln-selectize-create').each(function() {
				if ( ! $(this).hasClass('dln-added') ) {
					$(this).selectize({
						delimiter: ',',
						persist: false,
						create: function( input ) {
							return {
								value: input,
								text: input
							}
						}
					});
					$(this).addClass('dln-added');
				}
			});
		}
	});
}(jQuery));