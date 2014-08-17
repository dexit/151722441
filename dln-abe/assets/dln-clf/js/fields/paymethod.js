(function($) {
	"use strict";
		
	var onChangePayment = function () {
		var types = '';
		$('.list-group-item').each(function () {
			if ( $(this).hasClass('active') ) {
				var id = $(this).attr( 'id' );
				id = id.replace( 'dln_payment_', '' );
				types += $(this).attr( 'id' ) + ',';
			}
		});
		$('#dln_fs_payment_type').val( types );
	};
	
	$(document).ready(function () {
		$('#dln_payment_gift').on('click', function (e) {
			e.preventDefault();
			$('#dln_payment_sale').removeClass('active');
			$('#dln_payment_swap').removeClass('active');
			$(this).toggleClass('active');
			onChangePayment();
		});
		$('#dln_payment_sale').on('click', function (e) {
			e.preventDefault();
			$('#dln_payment_gift').removeClass('active');
			$(this).toggleClass('active');
			onChangePayment();
		});
		$('#dln_payment_swap').on('click', function (e) {
			e.preventDefault();
			$('#dln_payment_gift').removeClass('active');
			$(this).toggleClass('active');
			onChangePayment();
		});
	});
}(jQuery));