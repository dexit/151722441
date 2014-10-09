(function ($) {
	"use strict";
	
	$(document).on('ready', function () {

		//if ( typeof( $.fn.baraja ) == )
		var elm    = $('#dln_cards'),
			baraja = elm.baraja();

		$( '#dln_cards li' ).on( 'click', function( event ) {
			baraja.next();
		} );

		$('#card').on('click', function () {
			$(this).toggleClass('flipped');
		});

		var interval = '';
		var xhr      = '';
		$('#dln_daobai').on('click', function () {
			$(this).text( dln_horo_params.language.card_loading );
			baraja.next();
			if ( ! interval ) {
				interval = setInterval(function () {
					baraja.next();
				}, 500);

				// Send request to get cards infor
				if ( xhr )
					xhr.abort();
				xhr = $.ajax({
					url: dln_horo_params.dln_ajax_url,
					type: 'POST',
					data: {
						action           : 'dln_get_three_card',
						'ig_nonce_check' : dln_horo_params.dln_nonce
					},
					success: function ( data ) {
						if ( data ) {
							var timeout = setTimeout(function () {
								clearInterval(interval);
								clearTimeout(timeout);
							}, 2000);
						}
					},
					error: function ( error ) {
						console.log( error );
					}
				});
			}
		});
	});
})(jQuery);