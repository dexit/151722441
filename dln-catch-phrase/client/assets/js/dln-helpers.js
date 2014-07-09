/**
 * Created by DinhLN on 5/25/2014.
 */
var dlnServer    = 'http://localhost';
var dlnWPServer  = dlnServer + '/wordpress';

var DLN_Helpers = {
	createMatch : function ( client, room_name ) {
		if ( ! room_name )
			return false;
		var code = DLN_Encrypt.get_encrypt();
		// Create match
		$.ajax({
			url: dlnWPServer + '/wp-json/dln_post/',
			dataType: 'json',
			type: 'POST',
			data: {
				data : '{ "name" : "' + name + '", "title" : "' + name + '", "type" : "dln_match" }',
				code : code
			},
			success: function ( response ) {
				client.emit( 'send-match-id', response );
			},
			error: function ( error ) {
				console.log( "error: " + error.toString() );
			}
		});
	},

	joinMatch: function ( user_id, match_id, bet ) {
		if ( ! user_id || ! match_id || ! bet )
			return false;

		var code = DLN_Encrypt.get_encrypt();
		$.ajax({
			url: dlnWPServer + '/wp-json/user/match',
			dataType: 'json',
			type: 'POST',
			data: {
				data: '{"user_id":"' + user_id + '",  "match_id": "' + match_id + '", "bet": "' + bet + '"}',
				code: code
			},
			success: function ( response ) {
				if ( response == '1' ) {
					// to do anything
				} else {
					alert( response.toString() );
				}
			},
			error: function ( error ) {
				console.log( "error: " + error.toString() );
			}
		});
	}
};
