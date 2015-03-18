// Ionic Starter App

// angular.module is a global place for creating, registering and retrieving Angular modules
// 'starter' is the name of this angular module example (also set in a <body> attribute in index.html)
// the 2nd parameter is an array of 'requires'
// 'starter.controllers' is found in controllers.js

(function (app){
  'use strict';

  app.constant('GLOB', {
    host: 'http://vivufb.com/api/v1',
    name:'development',
    apiEndpoint:'http://dev.yoursite.com:10000/'
  });

  app.config(function($stateProvider, $urlRouterProvider) {

    $stateProvider
      .state('app', {
        url: '/app',
        abstract: true,
        templateUrl: 'templates/app.html',
        controller: 'AppCtrl'
      })
      .state('app.feeds', {
        url: '/feeds',
        views: {
          'appContent': {
            templateUrl: 'templates/feeds.html',
            controller: 'FeedsCtrl'
          }
        }
      })
      .state('app.feed', {
        url: '/feed/:feedId',
        views: {
          'appContent': {
            templateUrl: 'templates/feed.html',
            controller: 'FeedCtrl'
          }
        }
      })
      .state('app.pages', {
        url: '/feeds',
        views: {
          'appContent': {
            templateUrl: 'templates/pages.html',
            controller: 'PagesCtrl'
          }
        }
      });
    // if none of the above states are matched, use this as the fallback
    $urlRouterProvider.otherwise('/app/feeds');

  });

  app.run(function($rootScope, $ionicPlatform, $ionicLoading) {

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

  });

}(angular.module('dlnFeed', [
  'ionic',
  'ngCordova',
  'infinite-scroll',
  'mgcrea.pullToRefresh',
  'angularMoment',

  'dlnFeed.appCtrl',
  'dlnFeed.feedsCtrl',
  'dlnFeed.directives',
  'dlnFeed.filters'
])));


