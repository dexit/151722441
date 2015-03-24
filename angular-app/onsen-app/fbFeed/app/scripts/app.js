'use strict';

/**
 * @ngdoc overview
 * @name fbFeedApp
 * @description
 * # fbFeedApp
 *
 * Main module of the application.
 */
angular
  .module('fbFeedApp', [
    'ngAnimate',
    'ngCookies',
    'ngResource',
    'ngRoute',
    'ngSanitize',
    'ngTouch',
    'onsen',
    'angularMoment',
    'ngCordova',
    'infinite-scroll'
  ])
  .config(function ($routeProvider) {
    $routeProvider
      .when('/feeds', {
        templateUrl: 'views/feeds.html',
        controller: 'FeedsCtrl'
      })
      .otherwise({
        redirectTo: '/feeds'
      });
  })
  .run(function ($rootScope, $cordovaAppAvailability) {

    document.addEventListener('deviceready', function () {
      var scheme;
      if (device.platform === 'iOS') {
        scheme = 'fb://';
      }
      else if (device.platform === 'Android') {
        scheme = 'com.facebook.katana';
      }
      $cordovaAppAvailability.check(scheme)
        .then(function () {
          $rootScope.allowScheme = true;
        }, function () {
          $rootScope.allowScheme = false;
        });
    }, false);

  });
