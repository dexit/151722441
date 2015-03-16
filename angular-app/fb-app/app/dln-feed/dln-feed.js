'use strict';
angular.module('dlnFeed', [
  'ionic',
  'ngCordova',
  'ui.router',
  // TODO: load other modules selected during generation
])
  .run(function () {
  })
  .config(function ($stateProvider, $urlRouterProvider) {
    var baseTemp = 'dln-feed/templates';
    // some basic routing
    $stateProvider
      .state('app', {
        url: '/app',
        cache: false,
        abstract: true,
        templateUrl: baseTemp + '/main.html',
        controller: 'MainCtrl'
      })
      .state('app.feeds', {
        url: '/feed',
        cache: false,
        views: {
          'mainContent': {
            templateUrl: baseTemp + '/feeds.html',
            controller: 'FeedsCtrl'
          }
        }
      })
      .state('app.pages', {
        url: '/page',
        views: {
          'mainContent': {
            templateUrl: baseTemp + '/pages.html',
            controller: 'PagesCtrl'
          }
        }
      })
      .state('app.page', {
        url: '/page/:pageId',
        views: {
          'mainContent': {
            templateUrl: baseTemp + '/page.html',
            controller: 'PageCtrl'
          }
        }
      });

    $urlRouterProvider.otherwise('/app/feed');
  });
