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
    'ionic',
    'angularMoment',
    'infinite-scroll'
  ])
  .config(function($stateProvider, $urlRouterProvider) {

    $stateProvider
      .state('app', {
        url: '/app',
        abstract: true,
        templateUrl: 'views/app.html',
        controller: 'AppCtrl'
      })
      .state('app.feeds', {
        url: '/feeds',
        views: {
          'appContent': {
            templateUrl: 'views/feeds.html',
            controller: 'FeedsCtrl'
          }
        }
      });
      /*.state('app.feed', {
        url: '/feed/:feedId',
        views: {
          'appContent': {
            templateUrl: 'views/feed.html',
            controller: 'FeedCtrl'
          }
        }
      });*/

    // if none of the above states are matched, use this as the fallback
    $urlRouterProvider.otherwise('/app/feeds');
  })
  .run(function($rootScope, $ionicPlatform, $ionicLoading) {
    $ionicPlatform.ready(function() {
      // Hide the accessory bar by default (remove this to show the accessory bar above the keyboard
      // for form inputs)
      if (window.cordova && window.cordova.plugins.Keyboard) {
        cordova.plugins.Keyboard.hideKeyboardAccessoryBar(true);
      }
      if (window.StatusBar) {
        // org.apache.cordova.statusbar required
        StatusBar.styleDefault();
      }

    });

    $rootScope.showLoading = function (message) {
      $ionicLoading.show({
        template: message
      });
    };

    $rootScope.hideLoading = function () {
      $ionicLoading.hide();
    };

    FastClick.attach(document.body);
    /*window.f7 = new Framework7({
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
    };*/
  });
