(function ( window ){
	DLN_Socket = function () {};

	DLN_Socket.prototype = {
		init: function () {
			var that = this;
			//that.socket = io.connect( 'http://localhost:3000' );
			//that.socket.on( 'list-room', function ( rooms ) {
			//	console.log(rooms);
			//} );

			if ( $('.dln_check_point').length ) {
				$('.dln_check_point').on( 'click', function (e) {
					e.preventDefault();

					if ( navigator.geolocation ) {
						// timeout is 60000 miliseconds (60 seconds)
						var options = { timeout: 60000 };
						navigator.geolocation.getCurrentPosition( function ( position ) {
							if ( ! position )
								return;
							var latitude   = position.coords.latitude;
							var longitude  = position.coords.longitude;
							var user_id    = $('#dln_user_id').val();
							user_id        = parseInt( user_id );
							var location   = 'Hà Nội';

							if ( latitude && longitude ) {
								$.getJSON( 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' + latitude + ',' + longitude, function (data) {
									if ( data.status == 'OK' ) {
										for( var i = 0 ; i < data.results.length; i++ ) {
											if ( data.results[i]['types'][0] == 'street_address' ) {
												console.log(data.results[i]);
											}
										}
									} else {
										console.log( data );
										return false;
									}
								} );
							}

							//socket.emit( 'join-server', user_id  );
						}, function ( err ) {
							if ( err.code == 1 ) {
								alert( 'Error: Access is denied!' );
							} else if ( err.code == 2 ) {
								alert( 'Error: Position is unavailable!' );
							} else {
								alert( 'Error: undefined!' );
							}
						} );
					} else {
						alert( 'Sorry, browser does not support geolocation!' );
					}
				} );
				$('.dln_check_point').trigger( 'click' );
			}
		}
	};
})( window );
