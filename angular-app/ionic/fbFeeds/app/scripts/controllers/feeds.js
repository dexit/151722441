'use strict';

/**
 * @ngdoc function
 * @name fbFeedsApp.controller:FeedsCtrl
 * @description
 * # FeedsCtrl
 * Controller of the fbFeedsApp
 */
angular.module('fbFeedsApp')
  .controller('FeedsCtrl', function ($scope, $rootScope, fCache) {

    $rootScope.$on('onRefreshFeeds', function (e, args) {
      $scope.$emit('onRefreshFeeds', null);
    });

    $scope.$on('$ionicView.enter', function (e, args) {
      fCache.init(function () {
        $rootScope.$emit('onRequestFeeds', null);
      });
    });

  });
