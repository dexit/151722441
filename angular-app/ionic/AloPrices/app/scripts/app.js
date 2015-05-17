'use strict';

angular.module('aloPricesApp', [
  'ngAnimate',
  'ngCookies',
  'ngRoute',
  'ngSanitize',
  'ionic',
  'ngCordova',
  'pascalprecht.translate',
  'LocalStorageModule',
  'chart.js'
]).config(function ($translateProvider, $stateProvider, $urlRouterProvider, localStorageServiceProvider) {

  // Setting for languages.
  $translateProvider.preferredLanguage('vi');

  // Setting for local-storage.
  localStorageServiceProvider.setPrefix('aloPricesApp');
  localStorageServiceProvider.setStorageType('sessionStorage');
  localStorageServiceProvider.setStorageCookie(3, '/');

  /* Defalt route */
  $urlRouterProvider.otherwise('/home');

  /* For routes */
  $stateProvider
    .state('app', {
      url: '/',
      abstract: true,
      templateUrl: 'views/app.html',
      controller: 'AppCtrl'
    })
    .state('app.home', {
      url: 'home',
      views: {
        'home-tab': {
          templateUrl: 'views/home.html',
          controller: 'HomeCtrl'
        }
      }
    })
    .state('app.exchange_add', {
      url: 'them-ty-gia',
      views: {
        'home-tab': {
          templateUrl: 'views/exchange/exchange-add.html',
          controller: 'ExchangeAddCtrl'
        }
      }
    })
    .state('app.notifications', {
      url: 'notifications',
      views: {
        'notifications-tab': {
          templateUrl: 'views/notifications.html',
          controller: 'NotificationsCtrl'
        }
      }
    })
    .state('app.setting', {
      url: 'setting',
      views: {
        'setting-tab': {
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
