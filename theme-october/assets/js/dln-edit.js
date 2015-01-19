(function ($) {
	var resizeTimer;
	var objMasonry;
	
	$(document).ready(function () {
		$('#btn_toggle_filter').on('click', function (e) {
			e.preventDefault();
			$('.page-content-wrapper').first().toggleClass('active');

			if (objMasonry) {
				objMasonry.destroy();
			}
			objMasonry = new Masonry( '.dln-item-list', {
				columnWidth : 285,
				itemSelector : '.dln-item',
				isFitWidth : !0,
				isResizeBound : true
			});
		});
		
		$('.dln-slider-price').ionRangeSlider({
			type: "double",
		    min: 0.5,
		    max: 20,
		    from: 1,
		    to: 10,
		    step: 0.1,
		    grid: true,
		    postfix: " triệu",
		    max_postfix: "+",
		    values_separator: " → "
		});
		
		$.fn.tooltip && $('[data-toggle="tooltip"]').tooltip();
		
		$('.dln-slider-area').ionRangeSlider({
			type: "double",
		    min: 10,
		    max: 200,
		    from: 10,
		    to: 90,
		    step: 1,
		    grid: true,
		    postfix: " m<sup>2</sup>",
		    max_postfix: "+",
		    values_separator: " → "
		});
		
		window.SelectFx && $('select[data-init-plugin="cs-select"]').each(function() {
            var el = $(this).get(0);
            $(el).wrap('<div class="cs-wrapper"></div>'), new SelectFx(el)
        })
        
        $(window).on('resize', function () {
        	clearTimeout(resizeTimer);
        	resizeTimer = setTimeout(addMasonry, 300);
        });
		addMasonry();
	});
	
	var addMasonry = function () {
		if (! objMasonry) {
			objMasonry = new Masonry( '.dln-item-list', {
				columnWidth : 285,
				itemSelector : '.dln-item',
				isFitWidth : !0,
				isResizeBound : true
			});
		}
	}
}(jQuery));