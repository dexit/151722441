var arr_uuids = [];
module.exports = function (app, passport, facebookAppId, dlnServerUrl) {
	app.get('/auth/facebook_test', function (req, res) {
		console.log(req, res);
	});
	app.get('/auth/facebook', function (req, res) {
		arr_uuids.push(req.query.uuid);
		var path_url     = req.query.uuid;
		var redirect_uri = dlnServerUrl + '/auth/facebook/callback?path_url=' + path_url;
		var is_mobile    = true;
		var display      = ( is_mobile == true ) ? 'popup' : 'page';
		var auth_uri     = encodeURI('https://www.facebook.com/dialog/oauth?client_id=' + facebookAppId + '&redirect_uri=' + redirect_uri + '&scope=email&response_type=token&display=' + display);

		res.redirect(auth_uri);
	});
	/*app.get('/auth/facebook/callback', function (req, res, next) {
		var path_url = encodeURIComponent(req.query.path_url);
		passport.authenticate('facebook', {callbackURL:"/auth/facebook/callback?path_url="+path_url, successRedirect: '/auth/success?path_url='+path_url, failureRedirect: '/auth/failure?path_url='+path_url})(req, res, next);
	});*/
	app.get('/auth/facebook/callback', passport.authenticate('facebook', {successRedirect: '/auth/success', failureRedirect: '/auth/failure'}));
	app.get('/auth/success', function (req, res){
		//res.clearCookie('user_info', { path: '/auth/facebook' });
		//res.cookie('user_info', JSON.stringify(), { path: '/auth/facebook' });
		console.log(req);
		return;
		res.render('after-auth');
		//res.render('after-auth', { state: 'success', user: req.user ? req.user : null });
	});
	app.get('/auth/failure', function (req, res){
		res.json({state: 'success', user: req.user ? req.user: null});
	});
};