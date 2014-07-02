var slugs = require('slugs');
var Room = require('room.js');
var people = {};
var rooms = {};
var rooms_helper = require('rooms-helpers.js');
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
		console.log(key);
	} );
	return room;
}

module.exports = function (io, _) {
	io.sockets.on( 'connection', function ( client ) {

		client.on( 'join-server', function ( user_id, city_name ) {
			var exist = false;
			var ownerRoomID = inRoomID = null;

			// convert city name to slug name
			var slug_name = '';
			if ( city_name ) {
				slug_name = slugs( city_name );
			}
			if ( ! slug_name ) {
				client.emit('error', { message : 'Empty slug name!' });
				return;
			}

			exist = checkExistsRoom( slug_name );
			if ( ! exists ) {
				// Create new room
				var room = new Room( city_name, slug_name, user_id );
				rooms[slug_name] = room;
				console.log( 'user ' + user_id + ' just created room ' + slug_name );
			}

			// Join user to room
			var room = findRoom( slug_name );

			//https://maps.googleapis.com/maps/api/geocode/json?latlng=21.0333,105.8500

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

		client.on('add-user', function(username) {
			client.username = username;
			usernames[username] = username;

			client.emit('update-user-list', 'SERVER', 'you have connected!');
			client.broadcast.emit('update-user-list', 'SERVER', username + ' has connected!');
			io.sockets.emit('update-users', usernames);
		});
	});
}