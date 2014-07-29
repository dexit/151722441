(function($) {
	"use strict";
		
	var onChangePayment = function () {
		
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
		});
		$('#dln_payment_swap').on('click', function (e) {
			e.preventDefault();
			$('#dln_payment_gift').removeClass('active');
			$(this).toggleClass('active');
		});
	});
}(jQuery));