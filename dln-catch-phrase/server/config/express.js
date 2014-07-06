var express = require('express');
	path = require('path');
	favicon = require('static-favicon');
	logger = require('morgan');
	cookieParser = require('cookie-parser');
	bodyParser = require('body-parser');

module.exports = function (passport) {
	var app = express();

	var root = path.normalize(__dirname + '/..');

	app.set('showStackError', true);
	app.set('port', process.env.PORT || 3000);
	app.set('views', root + '/views');
	app.set('view engine', 'ejs');

	app.use(favicon());
	app.use(logger('dev'));
	app.use(bodyParser.json());
	app.use(bodyParser.urlencoded());
	app.use(cookieParser());

	app.use(passport.initialize());
	app.use(passport.session());
	app.use(express.Router());

	if ('development' == app.get('env')) {
		app.use(function(req, res, next) {
			console.log(req.url);
			next();
		});
	}

	return app;
}