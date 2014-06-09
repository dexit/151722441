module.exports = function (app, passport, facebookAppId, dlnServerUrl) {
	app.get('/auth/facebook_test', function (req, res) {
		console.log(req, res);
	});
	app.get('/auth/facebook', function (req, res) {
		var redirect_uri = dlnServerUrl + '/auth/facebook/callback';
		var is_mobile = true;
		var display = ( is_mobile == true ) ? 'popup' : 'page';
		var auth_uri = encodeURI('https://www.facebook.com/dialog/oauth?client_id=' + facebookAppId + '&redirect_uri=' + redirect_uri + '&scope=email&response_type=token&display=' + display);
console.log(req.query);
		res.redirect(auth_uri);
	});
	app.get('/auth/facebook/callback', passport.authenticate('facebook', {successRedirect: '/auth/success', failureRedirect: '/auth/failure'}));
	app.get('/auth/success', function (req, res){
		//res.clearCookie('user_info', { path: '/auth/facebook' });
		//res.cookie('user_info', JSON.stringify(), { path: '/auth/facebook' });
		//res.render('after-auth');
		res.render('after-auth', { state: 'success', user: req.user ? req.user : null });
	});
	app.get('/auth/failure', function (req, res){
		res.json({state: 'success', user: req.user ? req.user: null});
	});
};