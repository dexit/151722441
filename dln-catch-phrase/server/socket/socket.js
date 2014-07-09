var _            = require( 'underscore' );
var slug         = require( 'slug' );
var uuid         = require( 'node-uuid' );
var Room         = require( './room.js' );
var $            = require( 'jquery' );
var people       = {};
var rooms        = {};
var chat_history = {};
var dlnServer    = 'http://localhost';
var dlnWPServer  = dlnServer + '/wordpress';

module.exports = function ( io, _ ) {
	io.sockets.on( 'connection', function ( client ) {

		client.on( 'join-server', function ( user_id, name ) {
			var exists = false;
			var ownerRoomID = inRoomID = null;

			_.find( people, function ( key, value ) {
				if ( key.id === user_id )
					return exists = true;
			} );

			if ( exists ) {
				client.emit( 'error', { message : 'Bạn đã có trong hệ thống, xin vui lòng thử lại!' } );
			} else {
				people[user_id] = { 'name': name, 'owns': ownerRoomID, 'inroom': inRoomID, 'device': device };
				client.emit( 'update-log', 'Kết nối thành công!' );
				io.sockets.emit( 'update-log', people[user_id].name + ' đã tham gia!' );
				size_people = _.size( people );
				size_rooms = _.size( rooms );
				io.sockets.emit( 'update-people', { people: people, count: size_people } );
				client.emit( 'room-list', { rooms: rooms, count: size_rooms } );
				client.emit( 'joined' );
			}
		} );

		client.on( 'get-people-online', function ( fn ) {
			fn( { people: people } );
		} );

		client.on( 'country-update', function ( user_id, data ) {
			var country = data.country.toLowerCase();
			people[user_id].country = country;
			io.sockets.emit( 'update-people', { people: people, count: size_people } );
		} );

		client.on( 'typing', function ( user_id, data ) {
			if ( typeof people[user_id] !== undefined ) {
				io.sockets.in( client.room ).emit( 'is-typing', { is_typing: data, person: people[user_id].name } );
			}
		} );

		client.on( 'create-room', function ( user_id, room_name ) {
			if ( people[user_id].inroom ) {
				client.emit( 'update-log', 'Bạn chỉ có thể tham gia một phòng duy nhất, vui lòng thoát các phòng khác!' );
			} else if ( ! people[user_id].owns ) {
				var exists        = false;
				var random_number = Math.floor( Math.random() * 1001 );
				do {
					var id = name + random_number;
					_.find( rooms, function ( key, value ) {
						if ( key.id === id ) {
							return exists = true;
						}
					} );
				} while ( ! exists );

				var time_create = (new Date).getTime();
				var room   = new Room( room_name, id, user_id, time_create );
				rooms[id]  = room;
				size_rooms = _.size( rooms );
				io.sockets.emit( 'room-list', { rooms: rooms, count: size_rooms } );

				client.room = id;
				client.join( client.room );
				people[user_id].owns    = id;
				people[user_id].inrooms = id;
				room.addPerson( user_id );
				client.emit( 'update', 'Chào mừng bạn đến với phòng ' + room.name );
				client.emit( 'send-room-id', { id: id } );
				chat_history[client.room] = [];
			} {
				socket.emit( 'update-log', 'Bạn đã tạo phòng rồi!' );
			}
		} );

		client.on( 'check', function ( room_id, fn ) {
			var match = false;
			_.find( rooms, function ( key, value ) {
				if ( room.id === room_id ) {
					return match = true;
				}
			} );
			fn( { result: match } );
		} );

		client.on( 'remove-room', function ( room_id ) {
			var room = rooms[ room_id ];
			if ( client.id === room.owner ) {
				purge( client, 'remove-room' );
			} else {
				client.emit( 'update-log', 'Bạn phải là chủ phòng mới có quyền xoá phòng!' );
			}
		} );

		client.on( 'join-room', function ( user_id, room_id ) {
			if ( typeof ( people[ user_id ] !== 'undefined' ) ) {
				var room = rooms[ room_id ];
				if ( user_id === room.owner ) {
					client.emit( 'update-log', 'Bạn là chủ phòng này!' );
				} else {
					if ( people[ user_id ].inroom !== null ) {
						client.emit( 'update-log', 'Bạn đang trong phòng (' + rooms[people[user_id].inroom].name + '), xin vui lòng thoát phòng này!' );
					} else {
						room.addPerson( user_id );
						people[ user_id ].inroom = id;
						client.room = room.name;
						client.join( client.room );
						user = people[ user_id ];
						io.sockets.in( client.room).emit( 'update-log', user.name + ' đã tham gia phòng ' + room.name );
						client.emit( 'update-log', 'Chào mừng bạn tham gia phòng ' + room.name + '.' );
						client.emit( 'send-room-id', { id: id } );
						var key = _.keys( chat_history );
						if ( _.contains( keys, client.room ) ) {
							client.emit( 'history', chat_history[ client.room ] );
						}
					}
				}
			} else {
				client.emit( 'update-log', 'Please enter a valid name first.' );
			}
		} );

		client.on( 'leave-room', function ( room_id ) {
			var room = rooms[ room_id ];
			if ( room )
				purge( client, 'leave-room' );
		} );

		client.on( 'join-match', function ( user_id, match_id, money ) {
			$.ajax({
				url: dlnWPServer + '/wp-json/dln_post/',
				dataType: 'json',
				type: 'POST',
				data: {
					data: '{ "user_id" : "' + user_id + '", "match_id" : "' + match_id + '", "money" : "' + money + '" }'
				},
				success: function ( response ) {

				}
			});
		} );
	} );
};