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
      if (! $scope.feeds[index].page) {
        return false;
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

    $scope.$on('$ionicView.enter', function () {
      $('#dln_tab_feed').show();
    });

    $scope.$on('$ionicView.leave', function () {
      $('#dln_tab_feed').hide();
    });

    $rootScope.$on('onFeedRefreshFeeds', function (e, args) {
      $scope._page = 0;
      sFeed.getFeeds($scope, true);
    });

  });
