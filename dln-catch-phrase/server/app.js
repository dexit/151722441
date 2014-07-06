var fs = require('fs'),
	mongoose = require('mongoose'),
	passport = require('passport'),
	http = require('http'),
	_ = require('underscore'),
	mongodbURI = 'mongodb://localhost/test1234'; /* For example: mongodb://localhost/my-app-db */
	//facebookAppId = '1446113338979798',
	//facebookAppSecret = '0b996585ef99c01b4c486006a525e3d6',
	//dlnServerUrl = 'http://localhost:3000';

mongoose.connect(mongodbURI);

var models_path = __dirname + '/models';
 fs.readdirSync(models_path).forEach(function(file) {
	 if (file.substring(-3) === '.js') {
	    require(models_path + '/' + file);
	 }
 });

//require('./config/passport')(passport, facebookAppId, facebookAppSecret);

var app = require('./config/express')(passport);
app.set('port', process.env.PORT || 3000);
var server = app.listen(app.get('port'), function() {
	console.log('Express server listening on port ' + app.get('port'));
});

var io = require('socket.io').listen(server);
var socket_module = require('./socket/socket')(io, _);

exports = module.exports = app;
