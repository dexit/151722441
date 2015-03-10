(function(app) {

    app.config(function ($stateProvider, $urlRouterProvider, $locationProvider) {
        $locationProvider.html5Mode(true);
        $urlRouterProvider.otherwise('/home');
    });

    app.run(function () {
        /*window.f7App = new Framework7();
        window.$$ = Dom7;
        var mainView = window.f7App.addView('.view-main', {
            // Because we want to use dynamic navbar, we need to enable it for this view:
            dynamicNavbar: true,
            pushState: true
        });*/
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
])));
