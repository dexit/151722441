'use strict';

/* Controller */
dlnAppController.controller('successController', function ($scope, $window) {
	var user = $window.localStorage.getItem( 'user_json' );
	console.log(user);
});