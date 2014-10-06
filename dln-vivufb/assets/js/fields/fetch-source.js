(function($) {
	"use strict";
	
	
	$(document).ready(function () {
		$('#vff_btn_fetch').on('click', function (e) {
			e.preventDefault();
			
			// Get link
			var source_link = $('#dln_source_link').val();
			
			if ( ! source_link ) {
				// Alert error message when empty source link
				alert( dln_params.language.error_empty_source_link );
				return false;
			}
			
			var data = {};
			data.source_link = source_link;
			
			//var nonce = window.DLN_Helpers.encode( dln_params.dln_nonce );
			
			$.ajax({
				url: dln_params.dln_ajax_url,
				type: 'POST',
				data: {
					action      : 'dln_fetch_source',
					data        : data,
					nonce_check : dln_params.dln_nonce
				},
				success: function ( data ) {
					data = ( data ) ? JSON.parse( data ) : data;
					
					if ( data.status == 'success' ) {
						if ( JSON.stringify(data.content) == '{}' ) {
							alert( dln_params.language.error_empty_source_link );
							return false;
						}
						
						if ( data.content.id ) {
							$('#dln_card_avatar').attr('src', data.content.picture_url);
						}
						
						if ( data.content.name ) {
							$('#dln_card_name').text( data.content.name );
							$('#dln_source_title').val( data.content.name );
						}
						
						if ( data.content.website ) {
							$('#dln_card_link').attr( 'href', data.content.website );
						}
						
						if ( data.content.link ) {
							$('#dln_card_fb').attr( 'href', data.content.link );
						}
						
						if ( data.content.category ) {
							$('#dln_card_category').text( data.content.category );
							var category = data.content.category;
							category = category.replace( '/', ',' );
						}
						
						if ( data.content.sub_desc ) {
							$('#dln_card_desc').text( data.content.sub_desc );
						}
						
						if ( data.content.likes ) {
							$('#dln_card_likes').text( data.content.likes );
						}
						
						if ( data.content.talking_about_count ) {
							$('#dln_card_count').text( data.content.talking_about_count );
						}
						
					}
				},
				error: function ( error ) {
					console.log( error );
				}
			});
		});
	});
}(jQuery));