'use strict';

/**
 * @ngdoc function
 * @name fbFeedsApp.controller:FeedsCtrl
 * @description
 * # FeedsCtrl
 * Controller of the fbFeedsApp
 */
angular.module('fbFeedsApp')
  .controller('FeedsCtrl', function ($scope, $rootScope, fCache, localStorageService, fFeed) {

    $scope.toTimeZone = function (time) {
      return moment(time).add(7, 'hours');
    };

    $scope.gotoPage = function (index) {
      if (!$scope.feeds[index].page_id) {
        /*shareParams.setPage($scope.feeds[index].page);
         shareParams.setCategory($scope.feeds[index].category);*/
        return false;
      }

      $location.path('/pages/' + $scope.feeds[index].page_id);
    };

    $scope.gotoLink = function (url) {
      window.open(url, '_system', 'location=yes,toolbar=yes');
    };

    $rootScope.$on('onFeedRefreshFeeds', function (e, args) {
      $rootScope.$emit('onRefreshFeeds', null);
    });

    $scope.$on('$ionicView.enter', function (e, args) {
      fCache.init(function () {
        fFeed.init();
        fFeed.requestFeeds(function () {
          $scope.loading = fFeed.getLoading();
          $scope.feeds   = fFeed.getFeeds();
        });
        //$rootScope.$emit('onRequestFeeds', null);
      });
    });

  });
