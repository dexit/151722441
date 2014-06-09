module.exports = function (app, passport) {
	app.get('/auth/facebook_test', function (req, res) {
		console.log(req, res);
	});
	app.get('/auth/facebook', passport.authenticate('facebook'));
	app.get('/auth/facebook/callback', passport.authenticate('facebook', {successRedirect: '/auth/success', failureRedirect: '/auth/failure'}));
	app.get('/auth/success', function (req, res){
		res.clearCookie('user_info', { path: '/auth/facebook' });
		res.cookie('user_info', JSON.stringify(), { path: '/auth/facebook' });
		res.render('after-auth');
	});
	app.get('/auth/failure', function (req, res){
		res.json({state: 'success', user: req.user ? req.user: null});
	});
};