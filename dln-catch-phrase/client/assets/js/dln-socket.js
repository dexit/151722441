var dlnServer    = dlnServer || 'http://localhost';
var dlnWPServer  = dlnWPServer || dlnServer + '/wordpress';

(function (window) {
	DLN_Socket = function () {};

	DLN_Socket.getInstance = function () {
		if ( this.instance == null ) {
			this.instance = new DLN_Socket();
			this.instance.init();
			this.instance.onJoinMatch();
		}
		return this.instance;
	};

	DLN_Socket.prototype = {
		init: function () {
			var that = this;
			that.socket = io.connect( dlnServer + ':3000');
		},

		settingUpdateLog: function ( selector ) {
			if ( ! selector ) return false;
			var that = this;

			that.socket.on( 'update-log', function ( message ) {
				$( selector).append( '<p>' + message + '</p>' );
			} );
		},

		settingClearLog: function ( selector ) {
			if ( ! selector ) return false;
			var that = this;

			that.socket.on( 'clear-log', function () {
				$( selector).html('');
			} );
		},

		settingUpdatePeople: function ( selector ) {
			if ( ! selector ) return false;
			var that = this;

			that.socket.on( 'update-people', function ( message ) {
				// to do anything
			} );
		},

		onJoinMatch: function () {
			var that = this;

			that.socket.on( 'join-match', function ( data ) {
				if ( data.user_id && data.match_id && data.money ) {
					var code     = DLN_Encrypt.get_encrypt();
					var user_id  = parseInt( data.user_id );
					var match_id = parseInt( data.match_id );
					var money    = parseInt( data.money );
					$.ajax({
						url: dlnWPServer + '/wp-json/user/match',
						dataType: 'json',
						type: 'POST',
						data: {
							data: '{ "user_id":"' + user_id + '", "match_id":"' + match_id + '", "money" : "' + money + '" }',
							code: code
						},
						success: function ( response ) {
							var obj = JSON.parse( response.toString() );
						},
						error: function ( error ) {
							alert( error.toString() );
						}
					});
				} else {
					alert( data.toString() );
				}
			} );
		}
	}
})(window);