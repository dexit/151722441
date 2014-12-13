(function ($) {
	$(document).ready(function () {
		// For price
		$('#price').slider().on('slide', function (ev) {
			var val = min_val = max_val = '';
			var arr_val = [];
			if (val = $(this).val()) {
				arr_val = val.split(',');
				min_val = currency_formater(arr_val[0]);
				max_val = currency_formater(arr_val[1]);
				if ( max_val ) {
					max_val = max_val.replace('.0', '');
				}
				if ( arr_val[1] == 10000 ) {
					max_val = '10M+';
				}
				
				$('#min_price').text(min_val);
				$('#max_price').text(max_val);
			}
		});
		
		// For area
		$('#area').slider().on('slide', function (e) {
			var val = min_area = max_area = '';
			var arr_area = [];
			if (val = $(this).val()) {
				arr_area = val.split(',');
				min_area = arr_area[0] + 'm<sup>2</sup>';
				max_area = arr_area[1] + 'm<sup>2</sup>';
				if ( arr_area[1] == 500 ) {
					max_area = '500m<sup>2</sup>+';
				}
				
				$('#min_area').html(min_area);
				$('#max_area').html(max_area);
			}
		});
		
		// Show/Hide call button in info box
		$('.btn-show-number').on('click', function () {
			$('.dln-contact-fields').show();
			$('.primary-action-container').hide();
		});
		$('.btn-contact-hidden').on('click', function () {
			$('.dln-contact-fields').hide();
			$('.primary-action-container').show();
		});
		
		// Toggle side-content-container
		$('.sc-header').on('click', function () {
			var currentElm = $(this).closest('.side-content-container');
			$(currentElm).toggleClass('open');
			$('.sc-header .fa-angle-up').toggleClass('fa-angle-down');
		});
		$('.btn-header-action').on('click', function () {
			$('.sc-header').trigger('click');
		});
		
		// Toggle face
		$('.group-face button').on('click', function () {
			$('.group-face button.focus').removeClass('focus');
			$(this).addClass('focus');
		});
		
		$('.btn-header-nav').on('click', function () {
			$('.header-menu-dropdown').toggleClass('hidden');
		});
	});
	
	function currency_formater(num) {
		if (num >= 1000) {
	        return (num / 1000).toFixed(1) + 'M';
	    }
	    if (num >= 100) {
	        return (num / 100).toFixed(1) * 100 + 'k';
	    }
	}
}(jQuery));