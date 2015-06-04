'use strict';

angular.module('aloPricesApp', [
  'ngAnimate',
  'ngCookies',
  'ngRoute',
  'ngSanitize',
  'ionic',
  'ngCordova',
  'pascalprecht.translate',
  'chart.js',
  'angularMoment',
  'ngStorage'
]).config(function ($translateProvider, $stateProvider, $urlRouterProvider) {

  // Setting for languages.
  $translateProvider.preferredLanguage('vi');

  // Setting for local-storage.
  //localStorageServiceProvider.setPrefix('aloPricesApp');
  //localStorageServiceProvider.setStorageType('sessionStorage');
  //localStorageServiceProvider.setStorageCookie(3, '/');

  /* Defalt route */
  $urlRouterProvider.otherwise('/ty-gia');

  /* For routes */
  $stateProvider
    .state('app', {
      url: '/',
      abstract: true,
      templateUrl: 'views/app.html',
      controller: 'AppCtrl'
    })
    .state('app.exchanges', {
      url: 'ty-gia',
      views: {
        'exchanges-tab': {
          templateUrl: 'views/exchanges.html',
          controller: 'ExchangesCtrl',

          'list-currency': {
            templateUrl: 'views/partials/list-currency.html',
            controller: 'PartialsListCurrencyCtrl'
          }
        }
      }
    })
    .state('app.exchange_add', {
      url: 'them-ty-gia',
      views: {
        'exchanges-tab': {
          templateUrl: 'views/exchange/exchange-add.html',
          controller: 'ExchangeAddCtrl'
        }
      }
    })
    .state('app.exchange_detail', {
      url: 'ty-gia/:id',
      views: {
        'exchanges-tab': {
          templateUrl: 'views/exchange/exchange-detail.html',
          controller: 'ExchangeDetailCtrl'
        }
      }
    })
    .state('app.exchange_detail_list', {
      url: 'ty-gia/:id/chi-tiet',
      views: {
        'exchanges-tab': {
          templateUrl: 'views/exchange/exchange-detail-list.html',
          controller: 'ExchangeDetailListCtrl'
        }
      }
    })
    .state('app.golds', {
      url: 'gia-vang',
      views: {
        'golds-tab': {
          templateUrl: 'views/golds.html',
          controller: 'GoldsCtrl',

          'list-currency': {
            templateUrl: 'views/partials/list-currency.html',
            controller: 'PartialsListCurrencyCtrl'
          }
        }
      }
    })
    .state('app.gold_add', {
      url: 'them-gia-vang',
      views: {
        'golds-tab': {
          templateUrl: 'views/golds.html',
          controller: 'GoldsCtrl'
        }
      }
    })
    .state('app.gold_detail', {
      url: 'gia-vang/:id',
      views: {
        'exchanges-tab': {
          templateUrl: 'views/exchange/exchange-detail.html',
          controller: 'ExchangeDetailCtrl'
        }
      }
    })
    .state('app.exchange_detail_list', {
      url: 'gia-vang/:id/chi-tiet',
      views: {
        'exchanges-tab': {
          templateUrl: 'views/exchange/exchange-detail-list.html',
          controller: 'ExchangeDetailListCtrl'
        }
      }
    })
    .state('app.setting', {
      url: 'thiet-lap',
      views: {
        'app-content': {
          templateUrl: 'views/setting.html',
          controller: 'SettingCtrl'
        }
      }
    });

}).run(function ($ionicPlatform, $cordovaDevice, Device) {

  /* On ionic read platform */
  $ionicPlatform.ready(function () {
    // Hide the accessory bar by default (remove this to show the accessory bar above the keyboard
    // for form inputs)
    if (window.cordova && window.cordova.plugins.Keyboard) {
      cordova.plugins.Keyboard.hideKeyboardAccessoryBar(true);
    }
    if (window.StatusBar) {
      StatusBar.styleDefault();
    }
  });

});
