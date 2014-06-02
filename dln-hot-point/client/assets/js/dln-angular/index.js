/**
 * Created by DinhLN on 6/2/2014.
 */
var dlnApp = angular.module('dlnApp', ['ngRoute']);

// Configure our routes
dlnApp.config(function ($routeProvider) {
	$routeProvider
		// Route for home page
		.when('/', {
			templateUrl: 'pages/home.html',
			controller: 'mainController'
		})
		// Route for login page
		.when('/login', {
			templateUrl: 'pages/login.html',
			controller: 'loginController'
		});
});

// Cretate controller and inject to AngularJS $scope
dlnApp.controller('mainController', function($scope) {
	$scope.message = 'Welcome!';
});

dlnApp.controller('loginController', function($scope){
	$scope.message = 'Login';
});
