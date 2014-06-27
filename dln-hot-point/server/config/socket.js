var Room = require('room.js');
var people = {};
var rooms = {};
var rooms_helper = require('rooms-helpers.js');
var sockets = [];
var chatHistory = {};

function checkExistsRoom( roomID ) {
	var exists = false;
	_.find(rooms, function (key, value) {
		if ( key.id.toLowerCase() == roomID.toLowerCase() ) {
			return exists = true;
		}
	});

	return exists;
};

function createRoom( roomID, room ) {
	rooms[roomID] = room;

}

module.exports = function (io, _) {
	io.sockets.on('connection', function (client) {

		client.on('join-server', function (name, device, location_id) {
			var exist = false;
			var ownerRoomID = inRoomID = null;

			checkExistsRoom(location_id);

			if ( ! exists ) {
				// Create new room
				createRoom( location_id );
			} else {

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

		client.on('add-user', function(username) {
			client.username = username;
			usernames[username] = username;

			client.emit('update-user-list', 'SERVER', 'you have connected!');
			client.broadcast.emit('update-user-list', 'SERVER', username + ' has connected!');
			io.sockets.emit('update-users', usernames);
		});
	});
}