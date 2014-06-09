'use strict';

var dlnApp       = angular.module('dlnApp', ['ngRoute', 'dlnAppController']),
	dlnServer    = 'http://localhost',
	dlnPort      = '3000',
	dlnServerUrl = dlnServer + ':' + dlnPort;

/* Routes */
dlnApp.config(['$routeProvider', function ($routeProvider) {
	$routeProvider.when('/', {
		templateUrl: 'partials/login.html',
		controller: 'mainController'
	});
	$routeProvider.when('/login', {
		templateUrl: 'partials/hone.html',
		controller: 'loginController'
	});
	$routeProvider.when('/success_login', {
		templateUrl: 'partials/success_login.html',
		controller: 'successController'
	})
	$routeProvider.otherwise({
		redirectTo: '/'
	});
}]);

dlnApp.run(['$rootScope', '$window', 'sessionService', function($rootScope, $window, sessionService) {
	$rootScope.session = sessionService;
}]);