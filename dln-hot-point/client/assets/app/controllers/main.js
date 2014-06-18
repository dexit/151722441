'use strict';

/* Controller */
var dlnAppController = angular.module('dlnAppController', []);

dlnAppController.controller('mainController', function ($scope, $window) {
	$window.inviteCallback = function () {
		alert('a');
	}
	console.log('ok');
});