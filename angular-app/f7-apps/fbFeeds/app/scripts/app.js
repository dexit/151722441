'use strict';

/**
 * @ngdoc overview
 * @name fbFeedsApp
 * @description
 * # fbFeedsApp
 *
 * Main module of the application.
 */
angular
  .module('fbFeedsApp', [
    'ngAnimate',
    'ngCookies',
    'ngRoute',
    'ngSanitize',
    'ngTouch',
    'angularMoment'
  ])
  .config(function ($routeProvider) {
    /*$routeProvider
      .when('/', {
        templateUrl: 'views/main.html',
        controller: 'MainCtrl'
      })
      .when('/about', {
        templateUrl: 'views/about.html',
        controller: 'AboutCtrl'
      })
      .otherwise({
        redirectTo: '/'
      });*/
  })
  .run(function ($rootScope) {
    window.f7 = new Framework7({
      pushState: true,
      animateNavBackIcon: true
    });
    window.$$ = Dom7;

    window.mainView = window.f7.addView('.dln-view-main', {
      dynamicNavbar: true
    });
    //window.mainView.router.loadPage('views/feeds.html');

    $rootScope.gotoNavLink = function (url) {
      if (url) {
        window.mainView.router.loadPage(url);
      }
    };

    $rootScope.backNavLink = function () {
      window.mainView.router.back();
    };
  });
