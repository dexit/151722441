'use strict';

/**
 * @ngdoc overview
 * @name SNSContactsApp
 * @description
 * # SNSContactsApp
 *
 * Main module of the application.
 */
angular
  .module('SNSContactsApp')
  .config(function ($stateProvider, $urlRouterProvider, $translateProvider) {

    $stateProvider
      .state('app', {
        abstract: true,
        url: '',
        templateUrl: 'views/app.html',
        controller: 'AppCtrl'
      });

    // Set default route.
    $urlRouterProvider.otherwise('/');

    // Setting for languages.
    $translateProvider.preferredLanguage('vi');

  })
  .run(function ($ionicPlatform) {

    /**
     * Fire events when ionic ready.
     *
     * @return void
     */
    $ionicPlatform.ready(function() {
      // Hide the accessory bar by default (remove this to show the accessory bar above the keyboard
      // for form inputs)
      if(window.cordova && window.cordova.plugins.Keyboard) {
        cordova.plugins.Keyboard.hideKeyboardAccessoryBar(true);
      }
      if(window.StatusBar) {
        StatusBar.styleDefault();
      }
    });

  });