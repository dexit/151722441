module.exports = function (app, passport) {
	app.get('/auth/facebook', passport.authenticate('facebook'));
	app.get('/auth/facebook/callback', passport.authenticate('facebook', {successRedirect: '/auth/success', failureRedirect: '/auth/failure'}));
	app.get('/auth/success', function (req, res){
		console.log(req, res);
	});
	app.get('/auth/failure', function (req, res){
		console.log(req, res);
	});
};
