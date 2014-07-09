app.helpers.userHelper = function () {
	var dlnServer    = 'http://localhost',
		dlnWPServer  = dlnServer + '/wordpress',
		dlnPort      = '3000',
		dlnServerUrl = dlnServer + ':' + dlnPort;

	var __construct = function () {

	};

	this.resetUser = function () {
		this.avatar = null;
		this.name   = null;
		this.email  = null;
	};

	this.initUser = function ( userData ) {
		var user = {};
		if( userData && typeof( userData ) === 'string' ) {
			user = JSON.parse( userData );
			if ( user.fb_uid ) {
				this.avatar = 'https://graph.facebook.com/' + user.fb_uid + '/picture?width=64&height=64';
			} else if( user.avatar ) {
				this.avatar = user.avatar;
			}

			// Set border for avatar
			$('.navbar-main .avatar img').css('border', '2px solid #FFFFFF');
			this.name  = user.name;
			this.email = user.email;
		}
		return user;
	};

	this.getCurrentUser = function () {
		var objUser = {};
		var user = window.localStorage.getItem( 'user_json' );
		if ( user && typeof( user ) === 'string' ) {
			objUser = this.initUser( user );
		}
		return objUser;
	};

	this.loginFB = function () {
		var is_mobile = true;
		var width     = $(window).width(),
			height    = $(window).height(),
			path_url  = location.pathname,
			uuid      = $.now();
		var url_login = encodeURI( dlnWPServer + '/oauth/facebook?uuid=' + uuid );
		var popup = window.open(url_login, '_blank', 'width=' + width + ',height=' + height + ',scrollbars=0,toolbar=no,top=0,left=0');
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
	};

	this.login = function ( email, password ) {
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
	};

	this.logout = function () {
		this.resetUser();
		window.localStorage.removeItem('user_json');
		window.location = '#/login';
	};

	this.checkUserLoggedIn = function () {
		var isLoggedIn = false;
		var user = window.localStorage.getItem('user_json');
		if ( user && typeof(user) === 'string' ) {
			var objUser = {};
			objUser = this.initUser( user );
			if ( objUser ) {
				isLoggedIn = true;
			}
		}
		return isLoggedIn;
	}
};