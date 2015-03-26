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
    'infinite-scroll',
    'LocalStorageModule'
  ])
  .config(function($stateProvider, $urlRouterProvider, localStorageServiceProvider) {

    $stateProvider
      .state('app', {
        url: '/',
        abstract: true,
        templateUrl: 'views/app.html',
        controller: 'AppCtrl'
      })
      .state('app.feeds', {
        url: 'feeds',
        views: {
          'appContent': {
            templateUrl: 'views/feeds.html',
            controller: 'FeedsCtrl'
          }
        }
      })
      .state('app.page_detail', {
        url: 'pages/:pageId',
        views: {
          'appContent': {
            templateUrl: 'views/page-detail.html',
            controller: 'PageDetailCtrl'
          }
        }
      })
      .state('app.category_filter', {
        url: 'category_filter',
        views: {
          'appContent': {
            templateUrl: 'views/category-filter.html',
            controller: 'CategoryFilterCtrl'
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
    $urlRouterProvider.otherwise('/feeds');

    localStorageServiceProvider
      .setPrefix('fbFeedsApp')
      .setStorageCookieDomain('http://vivufb.com')
      .setNotify(true, true);
  })
  .run(function($rootScope, $ionicPlatform, $ionicLoading, $cordovaAppAvailability) {
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
      $ionicLoading.hide()
    };

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
