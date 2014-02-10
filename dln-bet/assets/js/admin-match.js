(function ($) {
	'use strict';
	
	$.DLN_AdminMatch = $.DLN_AdminMatch || {};
	
	$.DLN_AdminMatch.addChoose = function () {
		$('#newchoose-submit').click(function (e) {
			e.preventDefault();
			
			var _nonce = $('#_ajax_nonce-dln-add-choose').val();
			var post_id = $('#post_ID').val();
			$.post(
	            Dln_Ajax.ajaxurl,
	            {
	                action 		: 'dln_add_choose',
	                _ajax_nonce : _nonce,
	                post_id		: post_id
	            },
	            function( response ) {
	                var data = JSON.parse(response);
	                if ( data.action == 'dln_add_choose' ) {
	                	var html_row = '';
	                	if ( data.id ) {
	                		$('#list-match-body').append(data.html);
	                	}
	                } else {
	                	console.log( data );
	                }
	            })
			});
	};
	
	$.DLN_AdminMatch.deleteChoose = function () {
		$('.choose-delete').on('click', function (e) {
			e.preventDefault();
			
			var _nonce = $('#_ajax_nonce-dln-delete-choose').val();
			var post_id = $(this).data('id');
			$.post(
	            Dln_Ajax.ajaxurl,
	            {
	                action 		: 'dln_delete_choose',
	                _ajax_nonce : _nonce,
	                post_id		: post_id
	            },
	            function( response ) {
	                var data = JSON.parse(response);
	                if ( data.action == 'dln_delete_choose' ) {
	                	if ( data.id ) {
	                		$('#choose-row-' + data.id).remove();
	                	}
	                } else {
	                	console.log( data );
	                }
	            });
		});
	};
	
	$(document).ready(function () {
		$.DLN_AdminMatch.addChoose();
		$.DLN_AdminMatch.deleteChoose();
	});
}(jQuery));