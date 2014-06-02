var usernames = {};

module.exports = function (socket) {
    socket.on('add-user', function(username) {
		socket.username = username;
	    usernames[username] = username;

	    socket.emit('update-user-list', 'SERVER', 'you have connected!');
	    socket.broadcast.emit('update-user-list', 'SERVER', username + ' has connected!');
	    io.sockets.emit('update-users', usernames);
    });
}