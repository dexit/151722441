'use strict';

/**
 * @ngdoc function
 * @name fbFeedsApp.controller:PartialFeedsCtrl
 * @description
 * # PartialFeedsCtrl
 * Controller of the fbFeedsApp
 */
angular.module('fbFeedsApp')
  .controller('PartialFeedsCtrl', function ($scope, $http, $rootScope, $location, appGlobal, localStorageService, shareParams, fCache) {
    $scope.feeds = [];
    var page = 0;
    var last_request = '';
    $scope.loading = true;
    $scope.empty = false;
    $scope.allowScheme = false;



    $scope.requestFeeds = function ($done, isRefresh) {

    };

    $scope.scollGetFeeds = function () {
      if ($scope.loading) {
        return false;
      }

      //$scope.requestFeeds();
    };

    $scope.$on('ngRepeatFinished', function () {
      /*window.$$('img.lazy').trigger('lazy');*/
      $('img.lazy-images:not(.active)').each(function () {
        $(this).lazyload({
          effect: 'fadeIn'
        });
        $(this).trigger('appear');
        $(this).addClass('active');
      });
    });

    $rootScope.$on('onRefreshFeeds', function (e, args) {
      $scope.requestFeeds(null, true);
    });

    $rootScope.$on('onRequestFeeds', function (e, args) {
      $scope.loading = false;
console.log('ok');
      $scope.requestFeeds();
    });

  });
