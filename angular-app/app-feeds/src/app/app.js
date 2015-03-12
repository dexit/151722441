(function(app) {

    app.config(function ($stateProvider, $urlRouterProvider, $locationProvider) {
        //$locationProvider.html5Mode(true);
        $urlRouterProvider.otherwise('/home');
    });

    app.run(function ($rootScope) {
        window.f7App = new Framework7();
        window.$$ = Dom7;

        var mainView = window.f7App.addView('.view-main', {
            // Because we want to use dynamic navbar, we need to enable it for this view:
            dynamicNavbar: true,
            pushState: true,
			precompileTemplates: true,
			animateNavBackIcon: true
        });

		$rootScope.host = 'http://192.168.1.130/october/api/v1';

		$rootScope.showLoading = function (message) {
			window.f7App.showPreloader(message);
		};

		$rootScope.hideLoading = function () {
			window.f7App.hidePreloader();
		};
	});

    app.controller('AppController', function ($scope) {

    });

}(angular.module("dlnAppFeed", [
    'dlnAppFeed.home',
    'dlnAppFeed.about',
    'templates-app',
    'templates-common',
    'ui.router.state',
    'ui.router',
	'infinite-scroll',
	'dlnAppFeed.Directives',
	'angularMoment'
])));
