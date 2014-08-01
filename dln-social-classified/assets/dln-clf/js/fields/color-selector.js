(function($) {
	"use strict";
	
	var arr_selected = [];
	
	var get_selected_value = function ( id ) {
		/*console.log( ! $.inArray( id, arr_selected ) && arr_selected.length < 2 );
		if( ! $.inArray( id, arr_selected ) && arr_selected.length < 2 ) {
			arr_selected.shift();
			arr_selected.push(id);
		} else if ( $.inArray( id, arr_selected ) ) {
			arr_selected.pop( arr_selected.indexOf( id ) );
		}
		
		$('.dln-fs-color-item').removeClass('selected');
		$.each(arr_selected, function( i, val ) {
			$('.dln-fs-color-item[data-id="'+ val +'"]').addClass('selected');
		});*/
		var ids = '';
		$('.dln-fs-color-item.selected').each(function () {
			ids += $(this).data('id') + ',';
		});
		$('#dln_fs_color_selected').val(ids);
	};
	
	$(document).ready(function () {
		// Handle sub-items click
		$('.dln-fs-color-item').on( 'click', function (e) {
			e.preventDefault();

			//get_selected_value( $(this).data('id') );
			//if ( $('.dln-fs-color-item.selected').length < 2 ) {
				
				$(this).toggleClass('selected');
				$(this).find('.dln-fs-color-ico').toggleClass('ico-checkmark');
				var current_color = $(this).data('toggle-color');
				if ( $(this).hasClass('selected') ) {
					var color = '#FFFFFF';
					if ( current_color.toLowerCase() == '#ffffff' ) {
						color         = '#ffffff';
						current_color = '#cccccc';
					}
					$(this).css({
						'background-color' : current_color,
						'color'            : color
					});
					$(this).find('.dln-fs-color-ico').css({
						'color' : color
					});
				} else {
					$(this).css({
						'background-color' : '#FFFFFF',
						'color'            : 'none'
					});
				}
			//}
			
			get_selected_value();
		} );
	});
}(jQuery));