(function($) {
	"use strict";
	
	var template = '';
	
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
	
	var addSelectMetaChange = function ( that ) {
		$('#dln_field_meta_block').append(template);
	};
	
	var addSelectCreate = function () {
		if ( typeof( $.fn.selectize ) == 'function' ) {
			$('.dln-selectize-create').each(function () {
				if ( ! $(this).hasClass('has-selectize') ) {
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
					$(this).on('change', function () {
						addSelectMetaChange(this);
					});
					$(this).addClass('has-selectize');
				}
			});
		}
	};
	
	
	var capitalizeFirstLetter = function( string ) {
		return string.charAt(0).toUpperCase() + string.slice(1);
	};
	
	$(document).ready(function () {
		addSelectize();
		addSelectMultiple();
		
		// Get block meta-value html template
		template = $('#dln_field_meta_block').html();
		addSelectCreate();
	});
}(jQuery));