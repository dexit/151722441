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
    'ngCordova',
    'angularMoment'
  ])
  .config(function ($routeProvider, $locationProvider) {
    $routeProvider
      .when('/', {
        templateUrl: 'views/feeds.html',
        controller: 'FeedsCtrl'
      })
      .otherwise({
        redirectTo: '/'
      });
  })
  .run(function ($rootScope) {
    window.f7 = new Framework7({
      pushState: true,
      animateNavBackIcon: true
    });
    window.$$ = Dom7;


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
