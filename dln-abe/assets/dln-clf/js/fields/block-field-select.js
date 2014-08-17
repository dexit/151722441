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
		initSelectField();
	};
	
	var addSelectCreate = function (that) {
		if ( typeof( $.fn.selectize ) == 'function' ) {
			$(that).selectize({
				delimiter: ',',
				persist: false,
				maxItems: 1,
				create: function( input ) {
					return {
						value: input,
						text: capitalizeFirstLetter( input )
					}
				},
				onOptionAdd: function (value, data) {
					if ( ! $(that).hasClass('dln-added') ) {
						addSelectMetaChange(this);
						$(that).addClass('dln-added');
					}
				}
			});
		}
	};
	
	var setCloseButton = function () {
		$('.dln-field-close').on('click', function (e) {
			e.preventDefault();
			$(this).closest('.row').remove();
		});
	}
	
	var initSelectField = function() {
		$('select.dln-selectize-create').each(function () {
			if ( ! $(this).hasClass('has-selectize') ) {
				var that = this;
				addSelectCreate(that);
				setCloseButton();
				$(this).addClass('has-selectize');
			}
		});
	};
	
	var capitalizeFirstLetter = function( string ) {
		return string.charAt(0).toUpperCase() + string.slice(1);
	};
	
	$(document).ready(function () {
		addSelectize();
		addSelectMultiple();
		
		// Get block meta-value html template
		template = $('#dln_field_meta_block').html();
		
		initSelectField();
		// Hide close function for first load
		$('.dln-field-close').remove();
	});
}(jQuery));