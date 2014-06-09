var fs = require('fs'),
	mongoose = require('mongoose'),
	passport = require('passport'),
	http = require('http'),
	mongodbURI = 'mongodb://192.168.0.17/dinhlndb', /* For example: mongodb://localhost/my-app-db */
	facebookAppId = '251847918233636',
	facebookAppSecret = '31f3e2be38cd9a9e6e0a399c40ef18cd';

mongoose.connect(mongodbURI);

var models_path = __dirname + '/models';
console.log(models_path);
 fs.readdirSync(models_path).forEach(function(file) {
 if (file.substring(-3) === '.js') {
    require(models_path + '/' + file);
 }
 });

require('./config/passport')(passport, facebookAppId, facebookAppSecret);

var app = require('./config/express')(passport);

require('./config/routes')(app, passport);

http.createServer(app).listen(app.get('port'), function(){
	console.log('Express server listening on port ' + app.get('port'));
});

exports = module.exports = app;
