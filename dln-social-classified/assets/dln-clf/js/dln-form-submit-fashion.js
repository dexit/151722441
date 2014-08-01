(function($) {
	"use strict";
	
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
	
	var validateOnSubmitFashion = function () {
		var fs_tag_sizes = $('#dln_fs_tag_sizes').val();
		if ( ! fs_tag_sizes ) {
			alert( 'Please add fashion tag sizes' );
			return false;
		}
		
		var fs_category = $('#dln_fs_tag_sizes').val();
		if ( ! fs_category ) {
			alert( 'Please add fashion category' );
			return false;
		}
		
		return true;
	};
	
	$(document).ready(function () {
		if ( typeof ($.fn.selectize ) == 'function' ) {
			$('.dln-selectize').selectize();
		}
		
		// Bind validate when click submit form
		$('#dln_submit_fashion').on('click', function (e) {
			e.preventDefault();
			
			if ( validateOnSubmitFashion() ) {
				$('#submit_fashion_form').submit();
			}
		});
		
		// Add selectize multiple
		addSelectMultiple();
	});
}(jQuery));