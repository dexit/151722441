var _       = require('underscore');
var slug    = require('slug');
var Room    = require('./room.js');
var people  = {};
var rooms   = {};
var sockets = [];
var chatHistory = {};

function checkExistsRoom( slug_name ) {
	var exists = false;
	_.find(rooms, function ( key, value ) {
		if ( key.id.toLowerCase() == slug_name.toLowerCase() ) {
			return exists = true;
		}
	});

	return exists;
};

function findRoom( slug_name ) {
	var room = null;
	_.find( rooms, function ( key, value ) {
		if ( key.id === slug_name ) {
		return room = key;
		}
	} );
	return room;
};

function getSlugName( city_name ) {
	if ( ! city_name )
		return '';

	return slug( city_name).toLowerCase();
};

module.exports = function (io, _) {
	io.sockets.on( 'connection', function ( client ) {
		client.on( 'join-server', function ( user_id, city_name ) {
			console.log( 'user id ' + user_id + ' has joined!' );
			var exists = false;
			var ownerRoomID = inRoomID = null;

			// convert city name to slug name
			var slug_name = getSlugName( city_name );

			if ( ! slug_name ) {
				client.emit('error', { message : 'Empty slug name!' });
				return;
			}

			exists = checkExistsRoom( slug_name );
			if ( ! exists ) {
				// Create new room
				var room = new Room( city_name, slug_name, user_id );
				rooms[slug_name] = room;
				console.log( 'user ' + user_id + ' just created room ' + slug_name );
			}

			// Join user to room
			var room       = findRoom( slug_name );
			var size_rooms = _.size( rooms );
			if ( ! people[user_id].owns ) {
				client.room    = slug_name;
				client.join( client.room );
				people[user_id].owns = slug_name;
				people[user_id].inroom = slug_name;
				room.addPerson( user_id );
				client.emit( 'update-log', 'Welcome to ' + room.name + '.' );
				client.emit( 'send-room-id', { id: slug_name } );
			}

			/*_.find(people, function (key, value) {
				if ( key.name.toLowerCase() === name.toLowerCase() )
					return exists = true;
			});

			if ( exists ) {
				client.emit('user-exists', {msg: "The username already exists!"});
			} else {
				people[socket.id] = {"name" : name, "owns" : ownerRoomID, "inroom": inRoomID, "device": device};
				client.emit("log-update", "You have connected to the server.");
				io.sockets.emit("log-update", people[socket.id].name + " is online.")
				sizePeople = _.size(people);
				sizeRooms = _.size(rooms);
				io.sockets.emit("update-people", {people: people, count: sizePeople});
				client.emit("room-list", {rooms: rooms, count: sizeRooms});
				client.emit("joined"); //extra emit for GeoLocation
				sockets.push(socket);
			}*/
		});

		client.on( 'get-list-room', function () {
			var room_objs = JSON.stringify( rooms );
			client.emit( 'list-room', room_objs );
		} );

		client.on( 'get-list-user-in-room', function ( city_name ) {
			var users     = null;
			var slug_name = getSlugName( city_name );
			var room      = findRoom( slug_name );

			return JSON.stringify( room.people );
		} );

		client.on( 'check-point', function (user_id, lat, long, data) {

		} );

		client.on('add-user', function(username) {
			client.username = username;
			usernames[username] = username;

			client.emit('update-user-list', 'SERVER', 'you have connected!');
			client.broadcast.emit('update-user-list', 'SERVER', username + ' has connected!');
			io.sockets.emit('update-users', usernames);
		});
	});
}