'use strict';

/**
 * @ngdoc function
 * @name fbFeedsApp.controller:FeedsCtrl
 * @description
 * # FeedsCtrl
 * Controller of the fbFeedsApp
 */
angular.module('fbFeedsApp')
  .controller('FeedsCtrl', function ($scope, $rootScope, $location, fCache, sFeed, shareParams) {

    $scope.feeds = [];
    $scope._page = 0;
    $scope.last_request = '';
    $scope.loading = true;

    $scope.gotoPage = function (index) {
      if ($scope.feeds[index].page) {
        shareParams.setPage($scope.feeds[index].page);
        shareParams.setCategory($scope.feeds[index].category);
      }

      $location.path('/pages/' + $scope.feeds[index].page.id);
    };

    $scope.setFeeds = function (feeds) {
      $scope.feeds = feeds;
    };

    $scope.scollGetFeeds = function () {
      sFeed.getFeeds($scope);
    };

    $scope.init = function () {
      fCache.init(function () {
        $scope.loading = false;
        sFeed.getFeeds($scope);
      });
    };
    $scope.init();

    $rootScope.$on('onFeedRefreshFeeds', function (e, args) {
      $scope._page = 0;
      $scope.feeds = [];
      sFeed.getFeeds($scope, true);
    });

    $scope.$on('ngRepeatFinished', function() {
      $('img.lazy-images:not(.active)').each(function () {
        $(this).lazyload({
          effect : 'fadeIn'
        });
        $(this).trigger('appear');
        $(this).addClass('active');
      });
    });

  });
