(function(app) {

    app.config(['$stateProvider', '$urlRouterProvider', '$locationProvider', function ($stateProvider, $urlRouterProvider, $locationProvider) {
        //$locationProvider.html5Mode(true);
        $urlRouterProvider.otherwise('/home');
    }]);

    app.run(['$rootScope', function ($rootScope) {
        window.f7App = new Framework7();
        window.$$ = Dom7;
		var $$ = Dom7;

// Loading flag
		var loading = false;

// Last loaded index
		var lastIndex = $$('.list-block li').length;

        var mainView = window.f7App.addView('.view-main', {
            // Because we want to use dynamic navbar, we need to enable it for this view:
            dynamicNavbar: true,
            pushState: true,
			precompileTemplates: true
        });

		$rootScope.host = 'http://localhost/october/api/v1';

		$rootScope.showLoading = function (message) {
			window.f7App.showPreloader(message);
		};

		$rootScope.hideLoading = function () {
			window.f7App.hidePreloader();
		};
	}]);

    app.controller('AppController', ['$scope', function ($scope) {

    }]);

}(angular.module("dlnAppFeed", [
    'dlnAppFeed.home',
    'dlnAppFeed.about',
    'templates-app',
    'templates-common',
    'ui.router.state',
    'ui.router',
])));
