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

https://www.facebook.com/dialog/oauth?response_type=code&redirect_uri=http%3A%2F%2Flocalhost%3A3000%2Fauth%2Ffacebook%2Fcallback&client_id=251847918233636