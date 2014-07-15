app.helpers.userHelper = function () {};

app.helpers.userHelper.getInstance = function () {
	if ( this.instance == null ) {
		this.instance = new app.helpers.userHelper();
		this.instance.init();
	}

	return this.instance;
};

app.helpers.userHelper.prototype = {
	init: function () {
		var that         = this;
		that.dlnServer    = 'http://localhost',
		that.dlnWPServer  = dlnServer + '/wordpress',
		that.dlnPort      = '3000',
		that.dlnServerUrl = dlnServer + ':' + dlnPort;
	},

	resetUser : function () {
		var that    = this;
		that.avatar = null;
		that.name   = null;
		that.email  = null;
	},

	initUser: function ( user_data ) {
		var that = this;
		var user = {};
		if( user_data && typeof( user_data ) === 'string' ) {
			user = JSON.parse( user_data );
			if ( user.fb_uid ) {
				that.avatar = 'https://graph.facebook.com/' + user.fb_uid + '/picture?width=64&height=64';
			} else if( user.avatar ) {
				that.avatar = user.avatar;
			}

			// Set border for avatar
			$('.navbar-main .avatar img').css('border', '2px solid #FFFFFF');
			that.name  = user.name;
			that.email = user.email;
		}
		return user;
	},

	getCurrentUser: function () {
		var that    = this;
		var objUser = {};
		var user    = window.localStorage.getItem( 'user_json' );
		if ( user && typeof( user ) === 'string' ) {
			objUser = that.initUser( user );
		}
		return objUser;
	},

	loginFB: function () {
		var that      = this;
		var is_mobile = true;
		var width     = $(window).width(),
			height    = $(window).height(),
			path_url  = location.pathname,
			uuid      = $.now();
		var url_login = encodeURI( dlnWPServer + '/oauth/facebook?uuid=' + uuid );
		var popup = window.open( url_login, '_blank', 'width=' + width + ',height=' + height + ',scrollbars=0,toolbar=no,top=0,left=0');
		var popupTimer = window.setInterval(function () {
			if ( popup.closed !== false ) {
				window.clearInterval( popupTimer );
				$.ajax({
					url: dlnWPServer + '/wp-json/fbusers/' + uuid,
					dataType: 'json',
					type: 'GET',
					success: function ( response ) {
						if ( response ) {
							if ( response.ID ) {
								window.localStorage.setItem( 'user_json', JSON.stringify( response ) );
							}
						}

						window.location = '#home';
					}
				});
			}
		}, 200);
	},

	login: function () {
		var that = this;
		if ( ! email || ! password )
			return false;
		password = window.btoa( password );
		$.ajax({
			url: dlnWPServer + '/wp-json/user/login',
			dataType: 'json',
			type: 'POST',
			data: { data : '{ "email":"' + email + '",  "password": "' + password + '" }' },
			success: function ( response ) {
				if ( response ) {
					console.log( response );
				}
			}
		});
	},

	logout: function () {
		this.resetUser();
		console.log('ok');
		window.localStorage.removeItem('user_json');
		window.location = '#login';
	},

	checkUserLoggedIn: function () {
		var that       = this;
		var isLoggedIn = false;
		var user       = window.localStorage.getItem('user_json');
		if ( user && typeof(user) === 'string' ) {
			var objUser = {};
			objUser     = this.initUser( user );
			if ( objUser ) {
				isLoggedIn = true;
			}
		}
		return isLoggedIn;
	}
};