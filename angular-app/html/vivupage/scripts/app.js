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
    'ngCordova',
    'ionic',
    'angularMoment',
    'infinite-scroll',
    'LocalStorageModule'
  ])
  .config(function ($stateProvider, $urlRouterProvider, localStorageServiceProvider, $httpProvider) {
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
      .state('app.pages', {
        url: 'pages',
        views: {
          'appContent': {
            templateUrl: 'views/pages.html',
            controller: 'PagesCtrl'
          }
        }
      })
      .state('app.page', {
        url: 'pages/:pageId',
        views: {
          'appContent': {
            templateUrl: 'views/page.html',
            controller: 'PageCtrl'
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
      })
      .state('app.category', {
        url: 'category',
        views: {
          'appContent': {
            templateUrl: 'views/category.html',
            controller: 'CategoryCtrl'
          }
        }
      })
      .state('app.page_category', {
        url: 'category/:categoryId',
        views: {
          'appContent': {
            templateUrl: 'views/pages.html',
            controller: 'PagesCtrl'
          }
        }
      })
      .state('app.about', {
        url: 'about',
        views: {
          'appContent': {
            templateUrl: 'views/about.html',
            controller: 'AboutCtrl'
          }
        }
      });

    // if none of the above states are matched, use this as the fallback
    $urlRouterProvider.otherwise('/feeds');

    localStorageServiceProvider
      .setPrefix('fbFeedsApp')
      .setStorageCookie(3, '/')
      .setStorageType('sessionStorage')
      .setStorageCookieDomain('http://vivufb.com')
      .setNotify(true, true);

  })
  .run(function ($rootScope, $ionicPlatform, $ionicLoading, $cordovaAppAvailability, $cordovaDevice, $state, $window) {

    $rootScope.state = $state;

    /* Get width of windows */
    $rootScope.mainWidth = $window.innerWidth;

    /* Get UUID */
    try {
      $rootScope.uuid = $cordovaDevice.getUUID();
    } catch (err) {
      $rootScope.uuid = 'Simulator';
    }

    $rootScope.slideHeader = false;
    $rootScope.slideHeaderPrevious = 0;

    $ionicPlatform.ready(function () {
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

    $rootScope.gotoLink = function (url) {
      if ($rootScope.allowScheme) {
        window.open(url, '_system', 'location=yes,toolbar=yes');
      } else {
        window.open(url, '_blank');
      }
    };

    $rootScope.$on('ngRepeatFinished', function () {
      $('img.lazy-images:not(.active)').each(function () {
        $(this).lazyload({
          effect: 'fadeIn',
          skip_invisible: false
        });
        $(this).on('appear', function () {
          if ($(this).hasClass('dln-thumb-images')) {
            var height = $(this).height();
            var width = $(this).width();
            if (height && width) {
              $(this).closest('.dln-image-thumb').find('i.icon').css({
                'display': 'block'
              });
            }
          }
        });
        $(this).trigger('appear');
        $(this).addClass('active');
      });
    });

    document.addEventListener('deviceready', function () {
      var scheme;
      if (device.platform === 'iOS') {
        scheme = 'fb://';
      }
      else if (device.platform === 'Android') {
        scheme = 'com.facebook.katana';
      }


    }, false);

  });
