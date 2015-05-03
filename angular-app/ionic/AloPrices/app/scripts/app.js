'use strict';

angular.module('AloPrices', [
  'ngAnimate',
  'ngCookies',
  'ngRoute',
  'ngSanitize',
  'ionic',
  'ngCordova',
  'pascalprecht.translate'
]).config(function ($translateProvider, $stateProvider, $urlRouterProvider) {

  $translateProvider.preferredLanguage('vi');

  /* Defalt route */
  $urlRouterProvider.otherwise('/home');

  /* For routes */
  $stateProvider
    .state('app', {
      url: '/',
      abstract: true,
      templateUrl: 'views/app.html'
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

}).run(function ($ionicPlatform) {

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
