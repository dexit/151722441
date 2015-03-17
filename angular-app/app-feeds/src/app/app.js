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
			precompileTemplates: true
        });

		$rootScope.host = 'http://vivufb.com/api/v1';

		$rootScope.showLoading = function (message) {
			window.f7App.showPreloader(message);
		};

		$rootScope.hideLoading = function () {
			window.f7App.hidePreloader();
		};

		$rootScope.checkPhonegapBrowser = function () {
			if (window.device) {
				console.log('phonegap');
				return true;
			} else {
				console.log('web');
				return false;
			}
		};
	});

    app.controller('AppController', function ($scope, $rootScope) {
		$rootScope.checkPhonegapBrowser();
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
	'dlnAppFeed.Filters',
	'angularMoment',
])));

document.addEventListener("deviceready", onDeviceReady, false);

// device APIs are available
//
function onDeviceReady() {
	navigator.startApp.check("com.application.name", function(message) { /* success */
			console.log(message); // => OK
		},
		function(error) { /* error */
			console.log(error);
		});
}

